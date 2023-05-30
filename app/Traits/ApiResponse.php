<?php 
namespace App\Traits;
trait ApiResponse
{
    protected function apiSuccess($data,$code=200,$message=null)
    {
        return response()->json([
            'message'=>$message,
            'data'=>$data,
        ],$code);
    }
    protected function apiError($error,$code,$message=null)
    {
        return response()->json([
            'error'=>$error,
            'message'=>$message,
        ],$code);
    }
}
?>