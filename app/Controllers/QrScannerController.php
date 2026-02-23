<?php

namespace App\Controllers;

class QrScannerController extends BaseController
{
    public function scanner()
    {
        // Load the QR scanner view
        return view('attendance/scanner');
    }

    public function processScan()
    {
        // This method can be used to receive scanned QR code data via AJAX (optional)
        $qrData = $this->request->getPost('qrData');

        // For demo, just return the data as JSON
        return $this->response->setJSON([
            'status' => 'success',
            'data' => $qrData
        ]);
    }
}
