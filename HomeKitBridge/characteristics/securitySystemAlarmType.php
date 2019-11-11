<?php

declare(strict_types=1);

class HAPCharacteristicSecuritySystemAlarmType extends HAPCharacteristic
{
    const Alarm = 1;
    
    public function __construct()
    {
        parent::__construct(
            0x8E,
            HAPCharacteristicFormat::UnsignedInt8,
            [
                HAPCharacteristicPermission::PairedRead,
                HAPCharacteristicPermission::Notify
            ],
            0,
            1,
            1
        );
    }
}
