<?php

declare(strict_types=1);

class HAPAccessoryWindow extends HAPAccessoryBase
{
    use HelperSetDevice;

    public function __construct($data)
    {
        parent::__construct(
            $data,
            [
                new HAPServiceAccessoryInformation(),
                new HAPServiceWindow()
            ]
        );
    }
	
	public function notifyCharacteristicTargetPosition()
    {
        return [$this->data['TargetPosition']];
    }
	
	public function readCharacteristicTargetPosition()
    {
        return GetValue($this->data['TargetPosition']);
    }
	
	public function notifyCharacteristicCurrentPosition()
    {
        return [$this->data['CurrentPosition']];
    }

    public function readCharacteristicCurrentPosition()
    {
        return GetValue($this->data['CurrentPosition']);
    }

	public function notifyCharacteristicPositionState()
    {
        return [$this->data['PositionState']];
    }
	
	public function readCharacteristicPositionState()
    {
       return GetValue($this->data['PositionState']);
    }
	
	public function writeCharacteristicTargetPosition($value)
    {
        self::setDevice($this->data['TargetPosition'], $value);
    }
	
	public function writeCharacteristicCurrentPosition($value)
    {
        self::setDevice($this->data['CurrentPosition'], $value);
    }

    public function writeCharacteristicPositionState($value)
    {
		self::setDevice($this->data['PositionState'], $value);
    }
}

class HAPAccessoryConfigurationWindow
{
	use HelperSetDevice;
	
	public static function getPosition()
	{
		return 90;
	}
	
	public static function getCaption()
	{
       return 'Window';
	}
		
	public static function getColumns()
	{
		return [
			[
				'label' => 'TargetPosition',
				'name'  => 'TargetPosition',
				'width' => '150px',
				'add'   => 0,
				'edit'  => [
					'type' => 'SelectVariable'
				]
			],
			[
				'label' => 'CurrentPosition',
				'name'  => 'CurrentPosition',
				'width' => '150px',
				'add'   => 0,
				'edit'  => [
					'type' => 'SelectVariable'
				]
			],
			[
				'label' => 'PositionState',
				'name'  => 'PositionState',
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
		if (!IPS_VariableExists($data['TargetPosition'])) {
			return 'TargetPosition missing';
		}
		if (!IPS_VariableExists($data['CurrentPosition'])) {
			return 'CurrentPosition missing';
		}
		if (!IPS_VariableExists($data['PositionState'])) {
			return 'PositionState missing';
		}
		$variableTargetPosition = IPS_GetVariable($data['TargetPosition']);
		$variableCurrentPosition = IPS_GetVariable($data['CurrentPosition']);
		$variablePositionState = IPS_GetVariable($data['PositionState']);
		if ($variableTargetPosition['VariableType'] != 1 /* Integer */) {
			return 'TargetPosition: Integer required';
		}
		if ($variableCurrentPosition['VariableType'] != 1 /* Integer */) {
			return 'CurrentPosition: Integer required';
		}
		if ($variablePositionState['VariableType'] != 1 /* Integer */) {
			return 'PositionState: Integer required';
		}
		if ($variableTargetPosition['VariableCustomAction'] != '') {
			$profileAction = $variableTargetPosition['VariableCustomAction'];
		} else {
			$profileAction = $variableTargetPosition['VariableAction'];
		}
		if (!($profileAction > 10000)) {
			return 'TargetDoorState: Action required';
		}
		return 'OK';
	}

	public static function getTranslations()
	{
		return [
			'de' => [
				'Window'    => 'Fenster',
				'VariableID'            => 'VariablenID',
				'Variable missing'      => 'Variable fehlt',
				'Int required'          => 'Int benötigt',
				'Profile required'      => 'Profil benötigt',
				'Unsupported Profile'   => 'Falsches Profil',
				'OK'                    => 'OK'
			]
		];
	}
}
HomeKitManager::registerAccessory('Window');
	