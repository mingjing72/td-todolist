<?php

/**
 * 新增一条task记录
 * http方法： POST
 * 2017/06/09 Yangholmes
 */

/**
 * require libs
 */
require_once( __DIR__.'/../../php/config/server-config.php');
require_once( __DIR__.'/../../php/lib/yang-lib/yang-class-mysql.php');

/**
 * recieve POST data
 */
$task = $_POST['task'];

// date filter

/**
 * instance a new yangMysql class
 */
$taskQuery  = new yangMysql(); //
$taskQuery->selectDb(DB_DATABASE); //
$taskQuery->selectTable("task");

/**
 * insert new task
 */
$result = $task ? $taskQuery->insert($task) : false; // task can not be null

if(!$result){
  $error = '1';
  $errorMsg = '新增任务失败';
}
else{
  $result = $taskQuery->query('select @@IDENTITY');
  $condition = "id = '".$result[0]['@@IDENTITY']."'";
  $task = $taskQuery->simpleSelect(null, $condition, null, null)[0];
  $error = '0';
  $errorMsg = '';
}

$response = [
  "task"     => $task,
  "error"    => $error,
  "errorMsg" => $errorMsg
];
echo json_encode( $response );
