<?php

use App\Models\ApplicationModel;

function availableBalance()
{
    $model = new ApplicationModel('users', 'uid');
    $user = $model->select(['balance'])->where(['uid' => session('id'), 'user_detele_status' => 0])->first();
    return $user ? $user['balance'] : "0.00";
}

function availableBalanceByUserId($userId)
{
    $model = new ApplicationModel('users', 'uid');
    $user = $model->select(['balance'])->where(['uid' => $userId, 'user_detele_status' => 0])->first();
    return $user ? $user['balance'] : "0.00";
}

function deducatePoolPrice($userId, $amount)
{
    $model = new ApplicationModel('users', 'uid');
    $users = $model->select(['uid', 'balance'])->where(['user_detele_status' => 0, 'balance>=' => $amount])->whereIn('uid', $userId)->findAll();
    if (!$users) {
        return ['status' => false, 'message' => "Insufficent wallet amount to join.", 'data' => $userId];
    }
    $dif = array_diff($userId, array_column($users, 'uid'));
    if ($dif) {
        return ['status' => false, 'message' => "Insufficent wallet amount to join.", 'data' => $dif];
    }
    $wtrandData = [];
    foreach ($users as $user) {
        $wtrandData[] = [
            'user_id' => $user['uid'],
            'amount' => $amount,
            'amount_type' => 'dr',
            'transaction_type' => 'bet_amount',
            'before_balance' => $user['balance'],
            'after_balance' => $user['balance'] - $amount,
            'is_withdrawable' => 0
        ];
    }
    $transactionModel = new ApplicationModel('wallet_transactions', 'wid');
    $transactionModel->insertBatch($wtrandData);
    $x = $model->set('balance', '`balance` - ' . $amount, false)->where(['balance>=' => $amount])->whereIn('uid', $userId)->update();
    return ['status' => $x ? true : false, 'message' => "Something went wrong on false"];
}
