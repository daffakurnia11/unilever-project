<?php

namespace App\Helpers;

class ApiFormatter
{
  protected static $response = [
    'status'  => null,
    'message' => null,
    'count'   => null,
    'data'    => null
  ];

  public static function createApi($status = null, $message = null, $count = null, $data = null)
  {
    self::$response['status']   = $status;
    self::$response['message']  = $message;
    self::$response['count']    = $count;
    self::$response['data']     = $data;

    return response()->json(self::$response, self::$response['status']);
  }
}
