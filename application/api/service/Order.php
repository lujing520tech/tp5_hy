<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/11/18
 * Time: 15:34
 */

namespace app\api\service;


use app\api\model\Address;
use app\api\model\Goods;
use app\api\model\Order as OrderModel;
use app\api\model\OrderProduct;
use think\Exception;
use think\Db;

class Order
{
    protected $oProducts;

    protected $products;

    protected $uid;

    /**
     * @param $uid
     * @param $oProduct
     * 下单开始
     */
    public function place($uid, $oProduct)
    {
        $this->oProducts = $oProduct;
        $this->uid = $uid;
        $this->products = $this->getProductByOrder($oProduct);
        $status = $this->getorderStatus();
        if (!$status['pass']) {
            $status['order_id'] = -1;
            return $status;
        }
        //创建订单（快照）
        $orderSnap = $this->snapOrder($status);
        $createOrder = $this->createOrder($orderSnap);

    }

    private function createOrder($orderSnap)
    {
        try{
            Db::startTrans();//开启事务
            $orderNo = self::makeOrderNo();
            $orderModel = new OrderModel();
            $orderModel->order_no = $orderNo;
            $orderModel->user_id = $this->uid;
            $orderModel->total_price = $orderSnap['orderPrice'];
            $orderModel->total_count = $orderSnap['totalCount'];
            $orderModel->snap_img = $orderSnap['snapImg'];
            $orderModel->snap_name = $orderSnap['snapName'];
            $orderModel->snap_address = $orderSnap['snapAddress'];
            $orderModel->snap_items = json_encode($orderSnap['pStatus']);
            $orderModel->save();

            $orderId = $orderModel->id;
            $create_time = $orderModel->create_time;
            foreach ($this->oProducts as &$p){
                $p['order_id'] = $orderId;
            }
            $orderProduct = new OrderProduct();
            $orderProduct->saveAll($this->oProducts);
            Db::commit();
            return [
                'order_no' => $orderNo,
                'order_id' => $orderId,
                'create_time' => $create_time,
            ];
        }
        catch (Exception $ex){
            Db::rollback();
            throw $ex;
        }
    }

    /**
     * @param $orderId
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 对外的
     */
    public function checkOrderStatus($orderId)
    {
        $oProduct = OrderProduct::where('order_id','=',$orderId)
            ->select()->toArray();
        $this->oProducts = $oProduct;
        $this->products = $this->getProductByOrder($oProduct);
        $status = $this->getorderStatus();
        return $status;
    }

    //生成订单快照
    private function snapOrder($status)
    {
        $snap = [
            'orderPrice' => 0,
            'totalCount' => 0,
            'pStatus' => 0,
            'snapAddress' => 0,
            'snapName' => '',
            'snapImg' => '',
        ];
        $address_id = 1;//用户地址id
        $snap['orderPrice'] = $status['orderPrice'];
        $snap['totalCount'] = $status['totalCount'];
        $snap['pStatus'] = $status['pStatusArray'];
        $snap['snapAddress'] = json_encode($this->getUserSnapAddress($address_id));
        $snap['snapName'] = $this->products[0]['name'];
        $snap['snapImg'] = $this->products[0]['goods_img'];
        if(count($this->products)>1){
            $snap['snapName'].='等...';
        }


        return $snap;

    }

    /**
     * @return string
     * 生成订单号
     */
    public static function makeOrderNo()
    {
        $yCode = array('A','B','C','D','E','F','G','H','I','J','K',);
        $orderSn =
            $yCode[intval(date('Y'))-2020].strtoupper(dechex(date('m'))).date(
                'd').substr(time(),-5).substr(microtime(),2,5).sprintf(
                    '%02d',rand(0,99));
        return $orderSn;

    }



    /**
     * 查找用户地址
     */
    private function getUserSnapAddress($address_id)
    {
//        $result = Address::where(['uid','=',$this->uid])->find($address_id)->toArray();
        $result = [
            'name'=> 'lujing',
            'phone'=> '18300667463',
            'ster'=> '上海市，浦东新区，张江镇',
        ];
        return $result;
    }

    private function getProductByOrder($oProducts)
    {
        $oPIds = [];//push商品id
        foreach ($oProducts as $item) {
            array_push($oPIds, $item['product_id']);
        }
        $products = Goods::all($oPIds)
//            ->visible(['id','new_price','stock','name','goods_img'])
            ->toArray();
        return $products;
    }

    private function getorderStatus()
    {
        $status = [
            'pass' => true,
            'orderPrice' => 0,
            'pStatusArray' => [],
            'totalCount' => 0,
        ];

        foreach ($this->oProducts as $oProduct) {
            $pStatus = $this->getProductStatus($oProduct['product_id'], $oProduct['count'], $this->products);
            if (!$pStatus['haveStock']) {
                $status['pass'] = false;
            }
            $status['orderPrice'] += $pStatus['totalPrice'];
            $status['totalCount'] += $pStatus['count'];
        }
        return $status;
    }

    private function getProductStatus($oPId, $oCount, $products)
    {
        $pIndex = -1;
        $pStatus = [
            'id' => null,
            'haveStock' => false,
            'count' => 0,
            'name' => '',
            'totalPrice' => 0
        ];
        for ($i = 0; $i < count($products); $i++) {
            if ($oPId == $products[$i]['id']) {
                $pIndex = $i;
            }
        }
        if ($pIndex == -1) {

        } else {
            $products = $products[$pIndex];
            $pStatus['id'] = $products['id'];
            $pStatus['name'] = $products['name'];
            $pStatus['count'] = $oCount;
            $pStatus['totalPrice'] = $products['new_price'] * $oCount;
            if ($products['stock'] - $oCount >= 0) {
                $pStatus['haveStock'] = true;
            }
            return $pStatus;
        }
    }
}