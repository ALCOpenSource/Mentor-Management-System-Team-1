<?php

namespace App\Http\Controllers;

use App\Http\Resources\ApiResource;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    //
    public function generateCert(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        if (!empty($request->name)) 
        {
            $cert = generateCertificate($request->name);
            if($cert){
            return new ApiResource(['data' => $cert, 'message' => 'Certificate generated successfully.', 'status' => 200]);
        }
            return new ApiResource(['data' => null, 'message' => 'Certificate generation faild.', 'status' => 400]);
        }
    }
}
