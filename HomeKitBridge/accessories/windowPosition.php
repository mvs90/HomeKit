<?php

declare(strict_types=1);

class HAPAccessoryWindowPosition extends HAPAccessoryBase
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
        return [
            $this->data['VariableID']
        ];
    }

    public function readCharacteristicTargetPosition()
    {
        return $this->readCharacteristicCurrentPosition();
    }

    public function writeCharacteristicTargetPosition($value)
    {
        self::setDevice($this->data['VariableID'], $value);
    }

    public function notifyCharacteristicCurrentPosition()
    {
        return [
            $this->data['VariableID']
        ];
    }

    public function readCharacteristicCurrentPosition()
    {
        return $this->readCharacteristicCurrentPosition();
    }

    public function notifyCharacteristicPositionState()
    {
        return [];
    }

    public function readCharacteristicPositionState()
    {
        return HAPCharacteristicPositionState::Stopped;
    }
}

class HAPAccessoryConfigurationWindowPosition
{
    use HelperSetDevice;

    public static function getPosition()
    {
        return 90;
    }

    public static function getCaption()
    {
        return 'Window (Position)';
    }

    public static function getColumns()
    {
        return [
            [
                'label' => 'VariableID',
                'name'  => 'VariableID',
                'width' => '250px',
                'add'   => 0,
                'edit'  => [
                    'type' => 'SelectVariable'
                ]
            ]
        ];
    }

    public static function getStatus($data)
    {
        return self::getDimCompatibility($data['VariableID']);
    }

    public static function getTranslations()
    {
        return [
            'de' => [
                'Window (Position)'     => 'Rolladen/Jalousie (Position)',
                'VariableID'            => 'VariablenID',
                'Variable missing'      => 'Variable fehlt',
                'Int/Float required'    => 'Int/Float benötigt',
                'Profile required'      => 'Profil benötigt',
                'Action required'       => 'Aktion benötigt',
                'OK'                    => 'OK'
            ]
        ];
    }
}

HomeKitManager::registerAccessory('WindowPosition');
