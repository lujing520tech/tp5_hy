<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/11/19
 * Time: 17:44
 */

namespace app\api\service;

use app\api\service\Order as OrderService;
use app\api\model\Order as OrderModel;
use app\lib\exception\OrderException;
use app\api\service\Token as TokenService;
use think\Exception;
use app\lib\enum\OrderEnum;
use think\Loader;
use think\Log;

Loader::import('WxPay.WxPay', EXTEND_PATH, '.Api.php');

class Pay
{
    private $orderId;
    private $orderON;

    /**
     * Pay constructor.
     * @param $id
     * @throws Exception
     * 构成函数，赋值order_id
     */
    function __construct($id)
    {
        if (empty($id)) {
            throw new Exception([
                'msg' => '订单id不能为空'
            ]);
        }
        $this->orderId = $id;
    }

    /**
     * @return array
     * @throws OrderException
     * @throws \app\lib\exception\TokenException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 发起微信支付方法
     */
    public function pay()
    {
        //检测订单是否存在；
        //检测订单与用户是否匹配；
        //检测订单是否支付完成
        //检测订单是否有库存；
        $this->checkOrderValid();
        $status = (new OrderService())->checkOrderStatus($this->orderId);
        if (!$status['pass']) {
            return $status;
        }

        $this->makeWxPreOrder($status['orderPrice']);
    }

    /**
     * @param $totalprice
     * @throws OrderException
     * @throws \app\lib\exception\TokenException
     * 向微信提交预订单
     */
    private function makeWxPreOrder($totalPrice)
    {
        $openid = TokenService::getcurrentTokenVar('openid');
        if (!$openid) {
            throw new OrderException([
                'msg' => '用户的openid，不存在',
            ]);
        }
        $wxOrderData = new\WxPayUnifiedOrder();

        $wxOrderData->SetOut_trade_no($this->orderON);
        $wxOrderData->SetTrade_type('JSAPI');
        $wxOrderData->SetTotal_fee($totalPrice * 100);
        $wxOrderData->SetBody('CADIC');
        $wxOrderData->SetOpenid($openid);
        $wxOrderData->SetNotify_url('');
        return $this->getPaySignature($wxOrderData);
    }

    /**
     * @param $wxOrderData
     * @throws \WxPayException
     * 微信签名，及想微信发出https请求
     */
    private function getPaySignature($wxOrderData)
    {
        $wxOrder = \WxPayApi::unifiedOrder('', $wxOrderData);

        if ($wxOrder['return_code'] != 'SUCCESS' || $wxOrder['return_code'] != 'SUCCESS') {
            Log::record($wxOrder, 'error');
            Log::record('获取预支付订单失败', 'error');
        }

        $this->recordPreOrder($wxOrder);

        $rawValues = $this->sign($wxOrder);

        return $rawValues;
    }

    /**
     * @param $wxOrder
     * @return array
     * @throws \WxPayException
     * 拼装，返回小程序支付的参数
     */
    private function sign($wxOrder)
    {
        $jsApiPayData = new \WxPayJsApiPay();
        $jsApiPayData->SetAppid(config('wx.app_id'));
        $jsApiPayData->SetTimeStamp((string)time());
        $rand = md5(time() . mt_rand(0, 10000));
        $jsApiPayData->SetNonceStr($rand);
        $jsApiPayData->SetPackage('prepay_id=' . $wxOrder['prepay_id']);
        $jsApiPayData->SetSign('md5');
        $sign = $jsApiPayData->MakeSign();
        $rawValues = $jsApiPayData->GetValues();
        $rawValues['paySign'] = $sign;

        unset($rawValues['appId']);

        return $rawValues;
    }

    /**
     * @param $wxOrder
     * @return OrderModel
     * 将prepay_id 插入到数据库中，便于发送模板消息
     */
    private function recordPreOrder($wxOrder)
    {
        $orderUpdate = OrderModel::where('id', '=', $this->orderId)
            ->update(['prepay_id' => $wxOrder['prepay_id']]);
        return $orderUpdate;
    }


    /**
     * @return bool
     * @throws OrderException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 验证订单信息
     */
    private function checkOrderValid()
    {
        $order = OrderModel::where('order_id', '=', $this->orderId)->find();
        if (!$order) {
            throw new OrderException([
                'msg' => '订单未找到'
            ]);
        }
        $result = (new TokenService())->checkUserOrder($order->user_id);
        if (!$result) {
            throw new OrderException([
                'msg' => '订单用户身份不一致'
            ]);
        }

        if ($order->status != OrderEnum::UNPAID) {
            throw new OrderException([
                'msg' => '订单已被支付'
            ]);
        }
        $this->orderON = $order->order_no;
        return true;

    }
}