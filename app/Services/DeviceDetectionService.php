<?php
namespace App\Services;

class DeviceDetectionService
{
	//デバイス判定
    public function detectDeviceType($request)
	{
		$userAgent = $request->header('User-Agent');

        switch(true){
            case preg_match('/iPhone|Android/i',$userAgent) :
                return 'mobile';
                break;
            case preg_match('/iPad/i',$userAgent) :
                return 'tablet';
                break;
            default :
                return 'desktop';
                break;
        }
	}

	//デバイス判定と、ページネーションの値の設定
	public function getPaginationCountByDeviceType($request,$mobileCount,$tabletCount,$desktopCount)
	{
		$deviceType = $this->detectDeviceType($request);

		return match($deviceType){
			'mobile' => $mobileCount,
			'tablet' => $tabletCount,
			default => $desktopCount,
		};
	}
}