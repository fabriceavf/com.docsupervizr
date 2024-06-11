<?php

namespace App\Models;

use App\Observers\MachineObservers;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\SchemalessAttributes\SchemalessAttributesTrait;
use Throwable;


class Machine extends Model
{

    use SchemalessAttributesTrait;
    use SoftDeletes;


    /**
     * The primary key associated with the table.
     *
     * @var string
     */

    protected $primaryKey = '';
    protected $fillable = [
        'ID',
        'MachineAlias',
        'ConnectType',
        'IP',
        'SerialPort',
        'Port',
        'Baudrate',
        'MachineNumber',
        'IsHost',
        'Enabled',
        'CommPassword',
        'UILanguage',
        'DateFormat',
        'InOutRecordWarn',
        'Idle',
        'Voice',
        'managercount',
        'usercount',
        'fingercount',
        'SecretCount',
        'FirmwareVersion',
        'ProductType',
        'LockControl',
        'Purpose',
        'ProduceKind',
        'sn',
        'PhotoStamp',
        'IsIfChangeConfigServer2',
        'pushver',
        'change_operator',
        'change_time',
        'create_operator',
        'create_time',
        'delete_operator',
        'delete_time',
        'status',
        'device_type',
        'last_activity',
        'trans_times',
        'TransInterval',
        'log_stamp',
        'oplog_stamp',
        'photo_stamp',
        'UpdateDB',
        'device_name',
        'transaction_count',
        'main_time',
        'max_user_count',
        'max_finger_count',
        'max_attlog_count',
        'alg_ver',
        'flash_size',
        'free_flash_size',
        'language',
        'lng_encode',
        'volume',
        'is_tft',
        'platform',
        'brightness',
        'oem_vendor',
        'city',
        'AccFun',
        'TZAdj',
        'comm_type',
        'agent_ipaddress',
        'subnet_mask',
        'gateway',
        'area_id',
        'acpanel_type',
        'sync_time',
        'four_to_two',
        'video_login',
        'fp_mthreshold',
        'Fpversion',
        'max_comm_size',
        'max_comm_count',
        'realtime',
        'delay',
        'encrypt',
        'dstime_id',
        'door_count',
        'reader_count',
        'aux_in_count',
        'aux_out_count',
        'IsOnlyRFMachine',
        'alias',
        'ipaddress',
        'com_port',
        'com_address',
        'DeviceNetmask',
        'DeviceGetway',
        'SimpleEventType',
        'FvFunOn',
        'fvcount',
        'deviceOption',
        'DevSDKType',
        'UTableDesc',
        'IsTFTMachine',
        'PinWidth',
        'UserExtFmt',
        'FP1_NThreshold',
        'FP1_1Threshold',
        'Face1_NThreshold',
        'Face1_1Threshold',
        'Only1_1Mode',
        'OnlyCheckCard',
        'MifireMustRegistered',
        'RFCardOn',
        'Mifire',
        'MifireId',
        'NetOn',
        'RS232On',
        'RS485On',
        'FreeType',
        'FreeTime',
        'NoDisplayFun',
        'VoiceTipsOn',
        'TOMenu',
        'StdVolume',
        'VRYVH',
        'KeyPadBeep',
        'BatchUpdate',
        'CardFun',
        'FaceFunOn',
        'FaceCount',
        'TimeAPBFunOn',
        'FingerFunOn',
        'CompatOldFirmware',
        'ParamValues',
        'WirelessSSID',
        'WirelessKey',
        'WirelessAddr',
        'WirelessMask',
        'WirelessGateWay',
        'IsWireless',
        'ACFun',
        'BiometricType',
        'BiometricVersion',
        'BiometricMaxCount',
        'BiometricUsedCount',
        'WIFI',
        'WIFIOn',
        'WIFIDHCP',
        'IsExtend',
        'extra_attributes',
        'deleted_at',
        'identifiants_sadge',
        'creat_by',

    ];
    protected $casts = [

        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s',
        'deleted_at' => 'datetime:Y-m-d H:m:s',
    ];
    protected $with = [


    ];
    protected $appends = [
        'Selectvalue', 'Selectlabel'
    ];
    protected $schemalessAttributes = [
        'extra_attributes',
        'other_extra_attributes',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'Machines';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\MachineObservers') &&
                method_exists('\App\Observers\MachineObservers', 'creating')
            ) {

                try {
                    MachineObservers::creating($model);

                } catch (Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\MachineObservers') &&
                method_exists('\App\Observers\MachineObservers', 'created')
            ) {

                try {
                    MachineObservers::created($model);

                } catch (Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\MachineObservers') &&
                method_exists('\App\Observers\MachineObservers', 'updating')
            ) {

                try {
                    MachineObservers::updating($model);

                } catch (Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\MachineObservers') &&
                method_exists('\App\Observers\MachineObservers', 'updated')
            ) {

                try {
                    MachineObservers::updated($model);

                } catch (Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\MachineObservers') &&
                method_exists('\App\Observers\MachineObservers', 'deleting')
            ) {

                try {
                    MachineObservers::deleting($model);

                } catch (Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\MachineObservers') &&
                method_exists('\App\Observers\MachineObservers', 'deleted')
            ) {

                try {
                    MachineObservers::deleted($model);

                } catch (Throwable $e) {

                }
            }
        });
    }

    public function getIDAttribute($value)
    {
        return $value;
    }

    public function setIDAttribute($value)
    {
        $this->attributes['ID'] = $value ?? "";
    }

    public function getMachineAliasAttribute($value)
    {
        return $value;
    }

    public function setMachineAliasAttribute($value)
    {
        $this->attributes['MachineAlias'] = $value ?? "";
    }

    public function getConnectTypeAttribute($value)
    {
        return $value;
    }

    public function setConnectTypeAttribute($value)
    {
        $this->attributes['ConnectType'] = $value ?? "";
    }

    public function getIPAttribute($value)
    {
        return $value;
    }

    public function setIPAttribute($value)
    {
        $this->attributes['IP'] = $value ?? "";
    }

    public function getSerialPortAttribute($value)
    {
        return $value;
    }

    public function setSerialPortAttribute($value)
    {
        $this->attributes['SerialPort'] = $value ?? "";
    }

    public function getPortAttribute($value)
    {
        return $value;
    }

    public function setPortAttribute($value)
    {
        $this->attributes['Port'] = $value ?? "";
    }

    public function getBaudrateAttribute($value)
    {
        return $value;
    }

    public function setBaudrateAttribute($value)
    {
        $this->attributes['Baudrate'] = $value ?? "";
    }

    public function getMachineNumberAttribute($value)
    {
        return $value;
    }

    public function setMachineNumberAttribute($value)
    {
        $this->attributes['MachineNumber'] = $value ?? "";
    }

    public function getIsHostAttribute($value)
    {
        return $value;
    }

    public function setIsHostAttribute($value)
    {
        $this->attributes['IsHost'] = $value ?? "";
    }

    public function getEnabledAttribute($value)
    {
        return $value;
    }

    public function setEnabledAttribute($value)
    {
        $this->attributes['Enabled'] = $value ?? "";
    }

    public function getCommPasswordAttribute($value)
    {
        return $value;
    }

    public function setCommPasswordAttribute($value)
    {
        $this->attributes['CommPassword'] = $value ?? "";
    }

    public function getUILanguageAttribute($value)
    {
        return $value;
    }

    public function setUILanguageAttribute($value)
    {
        $this->attributes['UILanguage'] = $value ?? "";
    }

    public function getDateFormatAttribute($value)
    {
        return $value;
    }

    public function setDateFormatAttribute($value)
    {
        $this->attributes['DateFormat'] = $value ?? "";
    }

    public function getInOutRecordWarnAttribute($value)
    {
        return $value;
    }

    public function setInOutRecordWarnAttribute($value)
    {
        $this->attributes['InOutRecordWarn'] = $value ?? "";
    }

    public function getIdleAttribute($value)
    {
        return $value;
    }

    public function setIdleAttribute($value)
    {
        $this->attributes['Idle'] = $value ?? "";
    }

    public function getVoiceAttribute($value)
    {
        return $value;
    }

    public function setVoiceAttribute($value)
    {
        $this->attributes['Voice'] = $value ?? "";
    }

    public function getManagercountAttribute($value)
    {
        return $value;
    }

    public function setManagercountAttribute($value)
    {
        $this->attributes['managercount'] = $value ?? "";
    }

    public function getUsercountAttribute($value)
    {
        return $value;
    }

    public function setUsercountAttribute($value)
    {
        $this->attributes['usercount'] = $value ?? "";
    }

    public function getFingercountAttribute($value)
    {
        return $value;
    }

    public function setFingercountAttribute($value)
    {
        $this->attributes['fingercount'] = $value ?? "";
    }

    public function getSecretCountAttribute($value)
    {
        return $value;
    }

    public function setSecretCountAttribute($value)
    {
        $this->attributes['SecretCount'] = $value ?? "";
    }

    public function getFirmwareVersionAttribute($value)
    {
        return $value;
    }

    public function setFirmwareVersionAttribute($value)
    {
        $this->attributes['FirmwareVersion'] = $value ?? "";
    }

    public function getProductTypeAttribute($value)
    {
        return $value;
    }

    public function setProductTypeAttribute($value)
    {
        $this->attributes['ProductType'] = $value ?? "";
    }

    public function getLockControlAttribute($value)
    {
        return $value;
    }

    public function setLockControlAttribute($value)
    {
        $this->attributes['LockControl'] = $value ?? "";
    }

    public function getPurposeAttribute($value)
    {
        return $value;
    }

    public function setPurposeAttribute($value)
    {
        $this->attributes['Purpose'] = $value ?? "";
    }

    public function getProduceKindAttribute($value)
    {
        return $value;
    }

    public function setProduceKindAttribute($value)
    {
        $this->attributes['ProduceKind'] = $value ?? "";
    }

    public function getSnAttribute($value)
    {
        return $value;
    }

    public function setSnAttribute($value)
    {
        $this->attributes['sn'] = $value ?? "";
    }

    public function getPhotoStampAttribute($value)
    {
        return $value;
    }

    public function setPhotoStampAttribute($value)
    {
        $this->attributes['PhotoStamp'] = $value ?? "";
    }

    public function getIsIfChangeConfigServer2Attribute($value)
    {
        return $value;
    }

    public function setIsIfChangeConfigServer2Attribute($value)
    {
        $this->attributes['IsIfChangeConfigServer2'] = $value ?? "";
    }

    public function getPushverAttribute($value)
    {
        return $value;
    }

    public function setPushverAttribute($value)
    {
        $this->attributes['pushver'] = $value ?? "";
    }

    public function getChangeOperatorAttribute($value)
    {
        return $value;
    }

    public function setChangeOperatorAttribute($value)
    {
        $this->attributes['change_operator'] = $value ?? "";
    }

    public function getChangeTimeAttribute($value)
    {
        return $value;
    }

    public function setChangeTimeAttribute($value)
    {
        $this->attributes['change_time'] = $value ?? "";
    }

    public function getCreateOperatorAttribute($value)
    {
        return $value;
    }

    public function setCreateOperatorAttribute($value)
    {
        $this->attributes['create_operator'] = $value ?? "";
    }

    public function getCreateTimeAttribute($value)
    {
        return $value;
    }

    public function setCreateTimeAttribute($value)
    {
        $this->attributes['create_time'] = $value ?? "";
    }

    public function getDeleteOperatorAttribute($value)
    {
        return $value;
    }

    public function setDeleteOperatorAttribute($value)
    {
        $this->attributes['delete_operator'] = $value ?? "";
    }

    public function getDeleteTimeAttribute($value)
    {
        return $value;
    }

    public function setDeleteTimeAttribute($value)
    {
        $this->attributes['delete_time'] = $value ?? "";
    }

    public function getStatusAttribute($value)
    {
        return $value;
    }

    public function setStatusAttribute($value)
    {
        $this->attributes['status'] = $value ?? "";
    }

    public function getDeviceTypeAttribute($value)
    {
        return $value;
    }

    public function setDeviceTypeAttribute($value)
    {
        $this->attributes['device_type'] = $value ?? "";
    }

    public function getLastActivityAttribute($value)
    {
        return $value;
    }

    public function setLastActivityAttribute($value)
    {
        $this->attributes['last_activity'] = $value ?? "";
    }

    public function getTransTimesAttribute($value)
    {
        return $value;
    }

    public function setTransTimesAttribute($value)
    {
        $this->attributes['trans_times'] = $value ?? "";
    }

    public function getTransIntervalAttribute($value)
    {
        return $value;
    }

    public function setTransIntervalAttribute($value)
    {
        $this->attributes['TransInterval'] = $value ?? "";
    }

    public function getLogStampAttribute($value)
    {
        return $value;
    }

    public function setLogStampAttribute($value)
    {
        $this->attributes['log_stamp'] = $value ?? "";
    }

    public function getOplogStampAttribute($value)
    {
        return $value;
    }

    public function setOplogStampAttribute($value)
    {
        $this->attributes['oplog_stamp'] = $value ?? "";
    }

    public function getPhotoStampAttribute($value)
    {
        return $value;
    }

    public function setPhotoStampAttribute($value)
    {
        $this->attributes['photo_stamp'] = $value ?? "";
    }

    public function getUpdateDBAttribute($value)
    {
        return $value;
    }

    public function setUpdateDBAttribute($value)
    {
        $this->attributes['UpdateDB'] = $value ?? "";
    }

    public function getDeviceNameAttribute($value)
    {
        return $value;
    }

    public function setDeviceNameAttribute($value)
    {
        $this->attributes['device_name'] = $value ?? "";
    }

    public function getTransactionCountAttribute($value)
    {
        return $value;
    }

    public function setTransactionCountAttribute($value)
    {
        $this->attributes['transaction_count'] = $value ?? "";
    }

    public function getMainTimeAttribute($value)
    {
        return $value;
    }

    public function setMainTimeAttribute($value)
    {
        $this->attributes['main_time'] = $value ?? "";
    }

    public function getMaxUserCountAttribute($value)
    {
        return $value;
    }

    public function setMaxUserCountAttribute($value)
    {
        $this->attributes['max_user_count'] = $value ?? "";
    }

    public function getMaxFingerCountAttribute($value)
    {
        return $value;
    }

    public function setMaxFingerCountAttribute($value)
    {
        $this->attributes['max_finger_count'] = $value ?? "";
    }

    public function getMaxAttlogCountAttribute($value)
    {
        return $value;
    }

    public function setMaxAttlogCountAttribute($value)
    {
        $this->attributes['max_attlog_count'] = $value ?? "";
    }

    public function getAlgVerAttribute($value)
    {
        return $value;
    }

    public function setAlgVerAttribute($value)
    {
        $this->attributes['alg_ver'] = $value ?? "";
    }

    public function getFlashSizeAttribute($value)
    {
        return $value;
    }

    public function setFlashSizeAttribute($value)
    {
        $this->attributes['flash_size'] = $value ?? "";
    }

    public function getFreeFlashSizeAttribute($value)
    {
        return $value;
    }

    public function setFreeFlashSizeAttribute($value)
    {
        $this->attributes['free_flash_size'] = $value ?? "";
    }

    public function getLanguageAttribute($value)
    {
        return $value;
    }

    public function setLanguageAttribute($value)
    {
        $this->attributes['language'] = $value ?? "";
    }

    public function getLngEncodeAttribute($value)
    {
        return $value;
    }

    public function setLngEncodeAttribute($value)
    {
        $this->attributes['lng_encode'] = $value ?? "";
    }

    public function getVolumeAttribute($value)
    {
        return $value;
    }

    public function setVolumeAttribute($value)
    {
        $this->attributes['volume'] = $value ?? "";
    }

    public function getIsTftAttribute($value)
    {
        return $value;
    }

    public function setIsTftAttribute($value)
    {
        $this->attributes['is_tft'] = $value ?? "";
    }

    public function getPlatformAttribute($value)
    {
        return $value;
    }

    public function setPlatformAttribute($value)
    {
        $this->attributes['platform'] = $value ?? "";
    }

    public function getBrightnessAttribute($value)
    {
        return $value;
    }

    public function setBrightnessAttribute($value)
    {
        $this->attributes['brightness'] = $value ?? "";
    }

    public function getOemVendorAttribute($value)
    {
        return $value;
    }

    public function setOemVendorAttribute($value)
    {
        $this->attributes['oem_vendor'] = $value ?? "";
    }

    public function getCityAttribute($value)
    {
        return $value;
    }

    public function setCityAttribute($value)
    {
        $this->attributes['city'] = $value ?? "";
    }

    public function getAccFunAttribute($value)
    {
        return $value;
    }

    public function setAccFunAttribute($value)
    {
        $this->attributes['AccFun'] = $value ?? "";
    }

    public function getTZAdjAttribute($value)
    {
        return $value;
    }

    public function setTZAdjAttribute($value)
    {
        $this->attributes['TZAdj'] = $value ?? "";
    }

    public function getCommTypeAttribute($value)
    {
        return $value;
    }

    public function setCommTypeAttribute($value)
    {
        $this->attributes['comm_type'] = $value ?? "";
    }

    public function getAgentIpaddressAttribute($value)
    {
        return $value;
    }

    public function setAgentIpaddressAttribute($value)
    {
        $this->attributes['agent_ipaddress'] = $value ?? "";
    }

    public function getSubnetMaskAttribute($value)
    {
        return $value;
    }

    public function setSubnetMaskAttribute($value)
    {
        $this->attributes['subnet_mask'] = $value ?? "";
    }

    public function getGatewayAttribute($value)
    {
        return $value;
    }

    public function setGatewayAttribute($value)
    {
        $this->attributes['gateway'] = $value ?? "";
    }

    public function getAreaIdAttribute($value)
    {
        return $value;
    }

    public function setAreaIdAttribute($value)
    {
        $this->attributes['area_id'] = $value ?? "";
    }

    public function getAcpanelTypeAttribute($value)
    {
        return $value;
    }

    public function setAcpanelTypeAttribute($value)
    {
        $this->attributes['acpanel_type'] = $value ?? "";
    }

    public function getSyncTimeAttribute($value)
    {
        return $value;
    }

    public function setSyncTimeAttribute($value)
    {
        $this->attributes['sync_time'] = $value ?? "";
    }

    public function getFourToTwoAttribute($value)
    {
        return $value;
    }

    public function setFourToTwoAttribute($value)
    {
        $this->attributes['four_to_two'] = $value ?? "";
    }

    public function getVideoLoginAttribute($value)
    {
        return $value;
    }

    public function setVideoLoginAttribute($value)
    {
        $this->attributes['video_login'] = $value ?? "";
    }

    public function getFpMthresholdAttribute($value)
    {
        return $value;
    }

    public function setFpMthresholdAttribute($value)
    {
        $this->attributes['fp_mthreshold'] = $value ?? "";
    }

    public function getFpversionAttribute($value)
    {
        return $value;
    }

    public function setFpversionAttribute($value)
    {
        $this->attributes['Fpversion'] = $value ?? "";
    }

    public function getMaxCommSizeAttribute($value)
    {
        return $value;
    }

    public function setMaxCommSizeAttribute($value)
    {
        $this->attributes['max_comm_size'] = $value ?? "";
    }

    public function getMaxCommCountAttribute($value)
    {
        return $value;
    }

    public function setMaxCommCountAttribute($value)
    {
        $this->attributes['max_comm_count'] = $value ?? "";
    }

    public function getRealtimeAttribute($value)
    {
        return $value;
    }

    public function setRealtimeAttribute($value)
    {
        $this->attributes['realtime'] = $value ?? "";
    }

    public function getDelayAttribute($value)
    {
        return $value;
    }

    public function setDelayAttribute($value)
    {
        $this->attributes['delay'] = $value ?? "";
    }

    public function getEncryptAttribute($value)
    {
        return $value;
    }

    public function setEncryptAttribute($value)
    {
        $this->attributes['encrypt'] = $value ?? "";
    }

    public function getDstimeIdAttribute($value)
    {
        return $value;
    }

    public function setDstimeIdAttribute($value)
    {
        $this->attributes['dstime_id'] = $value ?? "";
    }

    public function getDoorCountAttribute($value)
    {
        return $value;
    }

    public function setDoorCountAttribute($value)
    {
        $this->attributes['door_count'] = $value ?? "";
    }

    public function getReaderCountAttribute($value)
    {
        return $value;
    }

    public function setReaderCountAttribute($value)
    {
        $this->attributes['reader_count'] = $value ?? "";
    }

    public function getAuxInCountAttribute($value)
    {
        return $value;
    }

    public function setAuxInCountAttribute($value)
    {
        $this->attributes['aux_in_count'] = $value ?? "";
    }

    public function getAuxOutCountAttribute($value)
    {
        return $value;
    }

    public function setAuxOutCountAttribute($value)
    {
        $this->attributes['aux_out_count'] = $value ?? "";
    }

    public function getIsOnlyRFMachineAttribute($value)
    {
        return $value;
    }

    public function setIsOnlyRFMachineAttribute($value)
    {
        $this->attributes['IsOnlyRFMachine'] = $value ?? "";
    }

    public function getAliasAttribute($value)
    {
        return $value;
    }

    public function setAliasAttribute($value)
    {
        $this->attributes['alias'] = $value ?? "";
    }

    public function getIpaddressAttribute($value)
    {
        return $value;
    }

    public function setIpaddressAttribute($value)
    {
        $this->attributes['ipaddress'] = $value ?? "";
    }

    public function getComPortAttribute($value)
    {
        return $value;
    }

    public function setComPortAttribute($value)
    {
        $this->attributes['com_port'] = $value ?? "";
    }

    public function getComAddressAttribute($value)
    {
        return $value;
    }

    public function setComAddressAttribute($value)
    {
        $this->attributes['com_address'] = $value ?? "";
    }

    public function getDeviceNetmaskAttribute($value)
    {
        return $value;
    }

    public function setDeviceNetmaskAttribute($value)
    {
        $this->attributes['DeviceNetmask'] = $value ?? "";
    }

    public function getDeviceGetwayAttribute($value)
    {
        return $value;
    }

    public function setDeviceGetwayAttribute($value)
    {
        $this->attributes['DeviceGetway'] = $value ?? "";
    }

    public function getSimpleEventTypeAttribute($value)
    {
        return $value;
    }

    public function setSimpleEventTypeAttribute($value)
    {
        $this->attributes['SimpleEventType'] = $value ?? "";
    }

    public function getFvFunOnAttribute($value)
    {
        return $value;
    }

    public function setFvFunOnAttribute($value)
    {
        $this->attributes['FvFunOn'] = $value ?? "";
    }

    public function getFvcountAttribute($value)
    {
        return $value;
    }

    public function setFvcountAttribute($value)
    {
        $this->attributes['fvcount'] = $value ?? "";
    }

    public function getDeviceOptionAttribute($value)
    {
        return $value;
    }

    public function setDeviceOptionAttribute($value)
    {
        $this->attributes['deviceOption'] = $value ?? "";
    }

    public function getDevSDKTypeAttribute($value)
    {
        return $value;
    }

    public function setDevSDKTypeAttribute($value)
    {
        $this->attributes['DevSDKType'] = $value ?? "";
    }

    public function getUTableDescAttribute($value)
    {
        return $value;
    }

    public function setUTableDescAttribute($value)
    {
        $this->attributes['UTableDesc'] = $value ?? "";
    }

    public function getIsTFTMachineAttribute($value)
    {
        return $value;
    }

    public function setIsTFTMachineAttribute($value)
    {
        $this->attributes['IsTFTMachine'] = $value ?? "";
    }

    public function getPinWidthAttribute($value)
    {
        return $value;
    }

    public function setPinWidthAttribute($value)
    {
        $this->attributes['PinWidth'] = $value ?? "";
    }

    public function getUserExtFmtAttribute($value)
    {
        return $value;
    }

    public function setUserExtFmtAttribute($value)
    {
        $this->attributes['UserExtFmt'] = $value ?? "";
    }

    public function getFP1NThresholdAttribute($value)
    {
        return $value;
    }

    public function setFP1NThresholdAttribute($value)
    {
        $this->attributes['FP1_NThreshold'] = $value ?? "";
    }

    public function getFP11ThresholdAttribute($value)
    {
        return $value;
    }

    public function setFP11ThresholdAttribute($value)
    {
        $this->attributes['FP1_1Threshold'] = $value ?? "";
    }

    public function getFace1NThresholdAttribute($value)
    {
        return $value;
    }

    public function setFace1NThresholdAttribute($value)
    {
        $this->attributes['Face1_NThreshold'] = $value ?? "";
    }

    public function getFace11ThresholdAttribute($value)
    {
        return $value;
    }

    public function setFace11ThresholdAttribute($value)
    {
        $this->attributes['Face1_1Threshold'] = $value ?? "";
    }

    public function getOnly11ModeAttribute($value)
    {
        return $value;
    }

    public function setOnly11ModeAttribute($value)
    {
        $this->attributes['Only1_1Mode'] = $value ?? "";
    }

    public function getOnlyCheckCardAttribute($value)
    {
        return $value;
    }

    public function setOnlyCheckCardAttribute($value)
    {
        $this->attributes['OnlyCheckCard'] = $value ?? "";
    }

    public function getMifireMustRegisteredAttribute($value)
    {
        return $value;
    }

    public function setMifireMustRegisteredAttribute($value)
    {
        $this->attributes['MifireMustRegistered'] = $value ?? "";
    }

    public function getRFCardOnAttribute($value)
    {
        return $value;
    }

    public function setRFCardOnAttribute($value)
    {
        $this->attributes['RFCardOn'] = $value ?? "";
    }

    public function getMifireAttribute($value)
    {
        return $value;
    }

    public function setMifireAttribute($value)
    {
        $this->attributes['Mifire'] = $value ?? "";
    }

    public function getMifireIdAttribute($value)
    {
        return $value;
    }

    public function setMifireIdAttribute($value)
    {
        $this->attributes['MifireId'] = $value ?? "";
    }

    public function getNetOnAttribute($value)
    {
        return $value;
    }

    public function setNetOnAttribute($value)
    {
        $this->attributes['NetOn'] = $value ?? "";
    }

    public function getRS232OnAttribute($value)
    {
        return $value;
    }

    public function setRS232OnAttribute($value)
    {
        $this->attributes['RS232On'] = $value ?? "";
    }

    public function getRS485OnAttribute($value)
    {
        return $value;
    }

    public function setRS485OnAttribute($value)
    {
        $this->attributes['RS485On'] = $value ?? "";
    }

    public function getFreeTypeAttribute($value)
    {
        return $value;
    }

    public function setFreeTypeAttribute($value)
    {
        $this->attributes['FreeType'] = $value ?? "";
    }

    public function getFreeTimeAttribute($value)
    {
        return $value;
    }

    public function setFreeTimeAttribute($value)
    {
        $this->attributes['FreeTime'] = $value ?? "";
    }

    public function getNoDisplayFunAttribute($value)
    {
        return $value;
    }

    public function setNoDisplayFunAttribute($value)
    {
        $this->attributes['NoDisplayFun'] = $value ?? "";
    }

    public function getVoiceTipsOnAttribute($value)
    {
        return $value;
    }

    public function setVoiceTipsOnAttribute($value)
    {
        $this->attributes['VoiceTipsOn'] = $value ?? "";
    }

    public function getTOMenuAttribute($value)
    {
        return $value;
    }

    public function setTOMenuAttribute($value)
    {
        $this->attributes['TOMenu'] = $value ?? "";
    }

    public function getStdVolumeAttribute($value)
    {
        return $value;
    }

    public function setStdVolumeAttribute($value)
    {
        $this->attributes['StdVolume'] = $value ?? "";
    }

    public function getVRYVHAttribute($value)
    {
        return $value;
    }

    public function setVRYVHAttribute($value)
    {
        $this->attributes['VRYVH'] = $value ?? "";
    }

    public function getKeyPadBeepAttribute($value)
    {
        return $value;
    }

    public function setKeyPadBeepAttribute($value)
    {
        $this->attributes['KeyPadBeep'] = $value ?? "";
    }

    public function getBatchUpdateAttribute($value)
    {
        return $value;
    }

    public function setBatchUpdateAttribute($value)
    {
        $this->attributes['BatchUpdate'] = $value ?? "";
    }

    public function getCardFunAttribute($value)
    {
        return $value;
    }

    public function setCardFunAttribute($value)
    {
        $this->attributes['CardFun'] = $value ?? "";
    }

    public function getFaceFunOnAttribute($value)
    {
        return $value;
    }

    public function setFaceFunOnAttribute($value)
    {
        $this->attributes['FaceFunOn'] = $value ?? "";
    }

    public function getFaceCountAttribute($value)
    {
        return $value;
    }

    public function setFaceCountAttribute($value)
    {
        $this->attributes['FaceCount'] = $value ?? "";
    }

    public function getTimeAPBFunOnAttribute($value)
    {
        return $value;
    }

    public function setTimeAPBFunOnAttribute($value)
    {
        $this->attributes['TimeAPBFunOn'] = $value ?? "";
    }

    public function getFingerFunOnAttribute($value)
    {
        return $value;
    }

    public function setFingerFunOnAttribute($value)
    {
        $this->attributes['FingerFunOn'] = $value ?? "";
    }

    public function getCompatOldFirmwareAttribute($value)
    {
        return $value;
    }

    public function setCompatOldFirmwareAttribute($value)
    {
        $this->attributes['CompatOldFirmware'] = $value ?? "";
    }

    public function getParamValuesAttribute($value)
    {
        return $value;
    }

    public function setParamValuesAttribute($value)
    {
        $this->attributes['ParamValues'] = $value ?? "";
    }

    public function getWirelessSSIDAttribute($value)
    {
        return $value;
    }

    public function setWirelessSSIDAttribute($value)
    {
        $this->attributes['WirelessSSID'] = $value ?? "";
    }

    public function getWirelessKeyAttribute($value)
    {
        return $value;
    }

    public function setWirelessKeyAttribute($value)
    {
        $this->attributes['WirelessKey'] = $value ?? "";
    }

    public function getWirelessAddrAttribute($value)
    {
        return $value;
    }

    public function setWirelessAddrAttribute($value)
    {
        $this->attributes['WirelessAddr'] = $value ?? "";
    }

    public function getWirelessMaskAttribute($value)
    {
        return $value;
    }

    public function setWirelessMaskAttribute($value)
    {
        $this->attributes['WirelessMask'] = $value ?? "";
    }

    public function getWirelessGateWayAttribute($value)
    {
        return $value;
    }

    public function setWirelessGateWayAttribute($value)
    {
        $this->attributes['WirelessGateWay'] = $value ?? "";
    }

    public function getIsWirelessAttribute($value)
    {
        return $value;
    }

    public function setIsWirelessAttribute($value)
    {
        $this->attributes['IsWireless'] = $value ?? "";
    }

    public function getACFunAttribute($value)
    {
        return $value;
    }

    public function setACFunAttribute($value)
    {
        $this->attributes['ACFun'] = $value ?? "";
    }

    public function getBiometricTypeAttribute($value)
    {
        return $value;
    }

    public function setBiometricTypeAttribute($value)
    {
        $this->attributes['BiometricType'] = $value ?? "";
    }

    public function getBiometricVersionAttribute($value)
    {
        return $value;
    }

    public function setBiometricVersionAttribute($value)
    {
        $this->attributes['BiometricVersion'] = $value ?? "";
    }

    public function getBiometricMaxCountAttribute($value)
    {
        return $value;
    }

    public function setBiometricMaxCountAttribute($value)
    {
        $this->attributes['BiometricMaxCount'] = $value ?? "";
    }

    public function getBiometricUsedCountAttribute($value)
    {
        return $value;
    }

    public function setBiometricUsedCountAttribute($value)
    {
        $this->attributes['BiometricUsedCount'] = $value ?? "";
    }

    public function getWIFIAttribute($value)
    {
        return $value;
    }

    public function setWIFIAttribute($value)
    {
        $this->attributes['WIFI'] = $value ?? "";
    }

    public function getWIFIOnAttribute($value)
    {
        return $value;
    }

    public function setWIFIOnAttribute($value)
    {
        $this->attributes['WIFIOn'] = $value ?? "";
    }

    public function getWIFIDHCPAttribute($value)
    {
        return $value;
    }

    public function setWIFIDHCPAttribute($value)
    {
        $this->attributes['WIFIDHCP'] = $value ?? "";
    }

    public function getIsExtendAttribute($value)
    {
        return $value;
    }

    public function setIsExtendAttribute($value)
    {
        $this->attributes['IsExtend'] = $value ?? "";
    }

    public function getIdentifiantsSadgeAttribute($value)
    {
        return $value;
    }

    public function setIdentifiantsSadgeAttribute($value)
    {
        $this->attributes['identifiants_sadge'] = $value ?? "";
    }

    public function getCreatByAttribute($value)
    {
        return $value;
    }

    public function setCreatByAttribute($value)
    {
        $this->attributes['creat_by'] = $value ?? "";
    }

    public function getSelectvalueAttribute()
    {
        $select = "";


        return trim($select);

    }

    public function getSelectlabelAttribute()
    {
        $select = "";


        return trim($select);


    }

    public function scopeWithExtraAttributes(): Builder
    {
        return $this->extra_attributes->modelScope();
    }

    public function scopeWithOtherExtraAttributes(): Builder
    {
        return $this->other_extra_attributes->modelScope();
    }


}

