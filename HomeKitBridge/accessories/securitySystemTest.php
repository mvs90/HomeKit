<?php

declare(strict_types=1);

class HAPAccessorySecuritySystemTest extends HAPAccessoryBase
{
    use HelperSetDevice;
	
	public function __construct($data)
    {
        parent::__construct(
            $data,
            [
                new HAPServiceAccessoryInformation(),
                new HAPServiceSecuritySystem()
            ]
        );
    }
	
    public function notifyCharacteristicSecuritySystemCurrentState()
    {
        return [
            $this->data['status']
        ];
    }
	
    public function readCharacteristicSecuritySystemCurrentState()
    {
        return GetValue($this->data['status']);
		
    }
	
    public function notifyCharacteristicStatusTampered()
    {
        return [
            $this->data['sabotage']
        ];
    }
	
    public function readCharacteristicStatusTampered()
    {
        return GetValue($this->data['sabotage']);
		
    }
    
    public function notifyCharacteristicSecuritySystemAlarmType()
    {
        return [
            $this->data['status']
        ];
    }
	
    public function readCharacteristicSecuritySystemAlarmType()
    {
        if (GetValue(($this->data['status']))== 4) {
            return HAPCharacteristicSecuritySystemAlarmType::Alarm;
        }
		
    }
    
    public function notifyCharacteristicSecuritySystemTargetState()
    {
        return [
            $this->data['status']
        ];
    }
	
    public function readCharacteristicSecuritySystemTargetState()
    {
        return GetValue($this->data['status']);
    }
	
    public function writeCharacteristicSecuritySystemTargetState($value)
    {
        self::setDevice($this->data['status'], $value);
    }
}

class HAPAccessoryConfigurationSecuritySystemTest
{
	use HelperSetDevice;
	
    public static function getPosition()
    {
        return 200;
    }
	
    public static function getCaption()
    {
        return 'Security System Test';
    }
	
    public static function getColumns()
    {
        return [
            [
                'label' => 'status',
                'name'  => 'status',
                'width' => '150px',
                'add'   => 0,
                'edit'  => [
                    'type' => 'SelectVariable'
                ]
            ],
            [
                'label' => 'sabotage',
                'name'  => 'sabotage',
                'width' => '150px',
                'add'   => 0,
                'edit'  => [
                    'type' => 'SelectVariable'
                ]
            ]
        ];
    }
	
    public static function getStatus($data)
    {
        if (!IPS_VariableExists($data['status'])) {
            return 'Variable missing';
        }
        $targetVariable = IPS_GetVariable($data['status']);
        if ($targetVariable['VariableType'] != 1 /* Integer */) {
            return 'Int required';
        }
	    if ($targetVariable['VariableCustomProfile'] != '') {
            $profileName = $targetVariable['VariableCustomProfile'];
        } else {
            $profileName = $targetVariable['VariableProfile'];
        }
        if (!IPS_VariableProfileExists($profileName)) {
            return 'Profile required';
        }
        if ($targetVariable['VariableCustomAction'] != '') {
            $profileAction = $targetVariable['VariableCustomAction'];
        } else {
            $profileAction = $targetVariable['VariableAction'];
        }
        if (!($profileAction > 10000)) {
            return 'Action required';
        }
        if (!IPS_VariableExists($data['sabotage'])) {
            return 'Variable missing';
        }
        return 'OK';
    }
	
    public static function getTranslations()
    {
        return [
            'de' => [
                'Security System'    => 'Alarmanlage',
                'status'            => 'status',
                'Variable missing'      => 'Variable fehlt',
                'Int required'          => 'Int benötigt',
                'Profile required'      => 'Profil benötigt',
                'OK'                    => 'OK'
            ]
        ];
    }
}

HomeKitManager::registerAccessory('SecuritySystemTest');