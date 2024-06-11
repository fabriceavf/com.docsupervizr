<?php

namespace App\Http\Controllers\API;

namespace App\Http\Controllers\API;

use App\Helpers\Helpers;
use App\Http\Actions\MachinesActions;
use App\Http\AgGrid;
use App\Http\Controllers\Controller;
use App\Http\Extras\MachineExtras;
use App\Models\Groupe;
use App\Models\Machine;
use App\Models\ser;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;
use Throwable;

// use App\Repository\prod\MachinesRepository;


class MachineController extends Controller
{

    private $MachinesRepository;
    private $menu;


    /**
     * Return .
     * @param Request $request
     * @param App\Repository\prod\MachinesRepository $MachinesRepository
     * @param int $id
     */
    public function __construct(Request $request)
    {


    }

    public function agGridData(Request $request)
    {
        $newFilter = $request->get('filterModel', []);
        $extras = $request->get('__extras__', []);
        if (!empty($extras['baseFilter']) && is_array($extras['baseFilter'])) {
            $oldFilter = $request->get('filterModel', []);
            $newFilter = array_merge($oldFilter, $extras['baseFilter']);
        }
        $request->merge(['filterModel' => $newFilter]);
        $query = Machine::query();
        if (!empty($extras['filterFields']) && is_array($extras['filterFields']) && !empty($extras['globalSearch'])) {
            $query->where(function ($q1) use ($extras) {

                foreach ($extras['filterFields'] as $key => $ex) {
                    $value = "%" . $extras['globalSearch'] . "%";
                    if ($key == 0) {

                        $q1->where($ex, "LIKE", $value);
                    } else {
                        $q1->orWhere($ex, "LIKE", $value);
                    }

                }

            });


        }
        if (
            class_exists('\App\Http\Extras\MachineExtras') &&
            method_exists('\App\Http\Extras\MachineExtras', 'filterAgGridQuery')
        ) {
            MachineExtras::filterAgGridQuery($request, $query);
        }


        $agGrid = new AgGrid('Machines', $query);
        $data = $agGrid->getData($request);

        if (
            class_exists('\App\Http\Extras\MachineExtras') &&
            method_exists('\App\Http\Extras\MachineExtras', 'AgGridUpdateDataBeforeReturnToUser')
        ) {
            $_d = $data['rowData'];
            $_d = MachineExtras::AgGridUpdateDataBeforeReturnToUser($request, $_d);
            $data['rowData'] = $_d;

            if ($_d->count() > $data['rowCount']) {
                $data['rowCount'] = $_d->count();
            }
        }

        return $data;
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return Response
     */
    public function data(Request $request, $key, $val)
    {
// La securite qui empeiche darriver sur cette sans avoir une signature valide
//if (! $request->hasValidSignature()) {
//abort(401);
//}
        $old = $request->all();
        $filter = [];
        if (array_key_exists('filter', $old)) {
            $filter = $old['filter'];

        }
        $filter[$key] = $val;
        $request->merge(['filter' => $filter]);

        if (!empty($_REQUEST["count"]) && $_REQUEST["count"] == 1) {
            return response()->json(Machine::count());
        }
        $data = QueryBuilder::for(Machine::class)
            ->allowedFilters([
                AllowedFilter::exact('ID'),


                AllowedFilter::exact('MachineAlias'),


                AllowedFilter::exact('ConnectType'),


                AllowedFilter::exact('IP'),


                AllowedFilter::exact('SerialPort'),


                AllowedFilter::exact('Port'),


                AllowedFilter::exact('Baudrate'),


                AllowedFilter::exact('MachineNumber'),


                AllowedFilter::exact('IsHost'),


                AllowedFilter::exact('Enabled'),


                AllowedFilter::exact('CommPassword'),


                AllowedFilter::exact('UILanguage'),


                AllowedFilter::exact('DateFormat'),


                AllowedFilter::exact('InOutRecordWarn'),


                AllowedFilter::exact('Idle'),


                AllowedFilter::exact('Voice'),


                AllowedFilter::exact('managercount'),


                AllowedFilter::exact('usercount'),


                AllowedFilter::exact('fingercount'),


                AllowedFilter::exact('SecretCount'),


                AllowedFilter::exact('FirmwareVersion'),


                AllowedFilter::exact('ProductType'),


                AllowedFilter::exact('LockControl'),


                AllowedFilter::exact('Purpose'),


                AllowedFilter::exact('ProduceKind'),


                AllowedFilter::exact('sn'),


                AllowedFilter::exact('PhotoStamp'),


                AllowedFilter::exact('IsIfChangeConfigServer2'),


                AllowedFilter::exact('pushver'),


                AllowedFilter::exact('change_operator'),


                AllowedFilter::exact('change_time'),


                AllowedFilter::exact('create_operator'),


                AllowedFilter::exact('create_time'),


                AllowedFilter::exact('delete_operator'),


                AllowedFilter::exact('delete_time'),


                AllowedFilter::exact('status'),


                AllowedFilter::exact('device_type'),


                AllowedFilter::exact('last_activity'),


                AllowedFilter::exact('trans_times'),


                AllowedFilter::exact('TransInterval'),


                AllowedFilter::exact('log_stamp'),


                AllowedFilter::exact('oplog_stamp'),


                AllowedFilter::exact('photo_stamp'),


                AllowedFilter::exact('UpdateDB'),


                AllowedFilter::exact('device_name'),


                AllowedFilter::exact('transaction_count'),


                AllowedFilter::exact('main_time'),


                AllowedFilter::exact('max_user_count'),


                AllowedFilter::exact('max_finger_count'),


                AllowedFilter::exact('max_attlog_count'),


                AllowedFilter::exact('alg_ver'),


                AllowedFilter::exact('flash_size'),


                AllowedFilter::exact('free_flash_size'),


                AllowedFilter::exact('language'),


                AllowedFilter::exact('lng_encode'),


                AllowedFilter::exact('volume'),


                AllowedFilter::exact('is_tft'),


                AllowedFilter::exact('platform'),


                AllowedFilter::exact('brightness'),


                AllowedFilter::exact('oem_vendor'),


                AllowedFilter::exact('city'),


                AllowedFilter::exact('AccFun'),


                AllowedFilter::exact('TZAdj'),


                AllowedFilter::exact('comm_type'),


                AllowedFilter::exact('agent_ipaddress'),


                AllowedFilter::exact('subnet_mask'),


                AllowedFilter::exact('gateway'),


                AllowedFilter::exact('area_id'),


                AllowedFilter::exact('acpanel_type'),


                AllowedFilter::exact('sync_time'),


                AllowedFilter::exact('four_to_two'),


                AllowedFilter::exact('video_login'),


                AllowedFilter::exact('fp_mthreshold'),


                AllowedFilter::exact('Fpversion'),


                AllowedFilter::exact('max_comm_size'),


                AllowedFilter::exact('max_comm_count'),


                AllowedFilter::exact('realtime'),


                AllowedFilter::exact('delay'),


                AllowedFilter::exact('encrypt'),


                AllowedFilter::exact('dstime_id'),


                AllowedFilter::exact('door_count'),


                AllowedFilter::exact('reader_count'),


                AllowedFilter::exact('aux_in_count'),


                AllowedFilter::exact('aux_out_count'),


                AllowedFilter::exact('IsOnlyRFMachine'),


                AllowedFilter::exact('alias'),


                AllowedFilter::exact('ipaddress'),


                AllowedFilter::exact('com_port'),


                AllowedFilter::exact('com_address'),


                AllowedFilter::exact('DeviceNetmask'),


                AllowedFilter::exact('DeviceGetway'),


                AllowedFilter::exact('SimpleEventType'),


                AllowedFilter::exact('FvFunOn'),


                AllowedFilter::exact('fvcount'),


                AllowedFilter::exact('deviceOption'),


                AllowedFilter::exact('DevSDKType'),


                AllowedFilter::exact('UTableDesc'),


                AllowedFilter::exact('IsTFTMachine'),


                AllowedFilter::exact('PinWidth'),


                AllowedFilter::exact('UserExtFmt'),


                AllowedFilter::exact('FP1_NThreshold'),


                AllowedFilter::exact('FP1_1Threshold'),


                AllowedFilter::exact('Face1_NThreshold'),


                AllowedFilter::exact('Face1_1Threshold'),


                AllowedFilter::exact('Only1_1Mode'),


                AllowedFilter::exact('OnlyCheckCard'),


                AllowedFilter::exact('MifireMustRegistered'),


                AllowedFilter::exact('RFCardOn'),


                AllowedFilter::exact('Mifire'),


                AllowedFilter::exact('MifireId'),


                AllowedFilter::exact('NetOn'),


                AllowedFilter::exact('RS232On'),


                AllowedFilter::exact('RS485On'),


                AllowedFilter::exact('FreeType'),


                AllowedFilter::exact('FreeTime'),


                AllowedFilter::exact('NoDisplayFun'),


                AllowedFilter::exact('VoiceTipsOn'),


                AllowedFilter::exact('TOMenu'),


                AllowedFilter::exact('StdVolume'),


                AllowedFilter::exact('VRYVH'),


                AllowedFilter::exact('KeyPadBeep'),


                AllowedFilter::exact('BatchUpdate'),


                AllowedFilter::exact('CardFun'),


                AllowedFilter::exact('FaceFunOn'),


                AllowedFilter::exact('FaceCount'),


                AllowedFilter::exact('TimeAPBFunOn'),


                AllowedFilter::exact('FingerFunOn'),


                AllowedFilter::exact('CompatOldFirmware'),


                AllowedFilter::exact('ParamValues'),


                AllowedFilter::exact('WirelessSSID'),


                AllowedFilter::exact('WirelessKey'),


                AllowedFilter::exact('WirelessAddr'),


                AllowedFilter::exact('WirelessMask'),


                AllowedFilter::exact('WirelessGateWay'),


                AllowedFilter::exact('IsWireless'),


                AllowedFilter::exact('ACFun'),


                AllowedFilter::exact('BiometricType'),


                AllowedFilter::exact('BiometricVersion'),


                AllowedFilter::exact('BiometricMaxCount'),


                AllowedFilter::exact('BiometricUsedCount'),


                AllowedFilter::exact('WIFI'),


                AllowedFilter::exact('WIFIOn'),


                AllowedFilter::exact('WIFIDHCP'),


                AllowedFilter::exact('IsExtend'),


                AllowedFilter::exact('identifiants_sadge'),


                AllowedFilter::exact('creat_by'),


                AllowedFilter::callback('not_null', function (Builder $query, $value) {
//                    dump($value);

                    if (!is_array($value)) {
                        $value = explode(',', $value);
                    }
                    foreach ($value as $val) {
                        $query->whereNotNull($val);

                    }


                    return $query;
                }),
                AllowedFilter::callback('null', function (Builder $query, $value) {
//                    dump($value);
                    if (!is_array($value)) {
                        $value = explode(',', $value);
                    }


                    foreach ($value as $val) {
                        $query->whereNull($val);

                    }


                    return $query;
                }),
                AllowedFilter::callback('date', function (Builder $query, $value) {
//                    dd($value);


                    if (!is_array($value)) {
                        $value = explode(',', $value);
                    }
                    foreach ($value as $val) {
                        $dat = explode('/', $val);
                        if (count($dat) == 3) {
                            if ($dat[1] != 'like') {
                                $query->where($dat[0], $dat[1], Carbon::parse($dat[2]));

                            } else {

                                $query->where($dat[0], "LIKE", "%" . $dat[2] . "%");
                            }
//                                dd($dat,$dat[0],Carbon::parse($dat[2]));

                        }

                    }


                    return $query;
                }),

                AllowedFilter::callback('like', function (Builder $query, $value) {
                    if (!is_array($value)) {
                        $value = explode(',', $value);
                    }

                    foreach ($value as $val) {
                        $dat = explode('/', $val);
                        if (count($dat) == 2) {
                            $query->where($dat[0], "LIKE", "%" . $dat[1] . "%");

                        }

                    }


                    return $query;
                }),
                AllowedFilter::callback('where', function (Builder $query, $value) {
                    if (!is_array($value)) {
                        $value = explode(',', $value);
                    }

                    foreach ($value as $val) {
                        $dat = explode('/', $val);
                        if (count($dat) == 3) {
                            $query->where($dat[0], $dat[1], $dat[2]);

                        }

                    }


                    return $query;
                }),
            ])
            ->allowedSorts([
                AllowedSort::field('ID'),


                AllowedSort::field('MachineAlias'),


                AllowedSort::field('ConnectType'),


                AllowedSort::field('IP'),


                AllowedSort::field('SerialPort'),


                AllowedSort::field('Port'),


                AllowedSort::field('Baudrate'),


                AllowedSort::field('MachineNumber'),


                AllowedSort::field('IsHost'),


                AllowedSort::field('Enabled'),


                AllowedSort::field('CommPassword'),


                AllowedSort::field('UILanguage'),


                AllowedSort::field('DateFormat'),


                AllowedSort::field('InOutRecordWarn'),


                AllowedSort::field('Idle'),


                AllowedSort::field('Voice'),


                AllowedSort::field('managercount'),


                AllowedSort::field('usercount'),


                AllowedSort::field('fingercount'),


                AllowedSort::field('SecretCount'),


                AllowedSort::field('FirmwareVersion'),


                AllowedSort::field('ProductType'),


                AllowedSort::field('LockControl'),


                AllowedSort::field('Purpose'),


                AllowedSort::field('ProduceKind'),


                AllowedSort::field('sn'),


                AllowedSort::field('PhotoStamp'),


                AllowedSort::field('IsIfChangeConfigServer2'),


                AllowedSort::field('pushver'),


                AllowedSort::field('change_operator'),


                AllowedSort::field('change_time'),


                AllowedSort::field('create_operator'),


                AllowedSort::field('create_time'),


                AllowedSort::field('delete_operator'),


                AllowedSort::field('delete_time'),


                AllowedSort::field('status'),


                AllowedSort::field('device_type'),


                AllowedSort::field('last_activity'),


                AllowedSort::field('trans_times'),


                AllowedSort::field('TransInterval'),


                AllowedSort::field('log_stamp'),


                AllowedSort::field('oplog_stamp'),


                AllowedSort::field('photo_stamp'),


                AllowedSort::field('UpdateDB'),


                AllowedSort::field('device_name'),


                AllowedSort::field('transaction_count'),


                AllowedSort::field('main_time'),


                AllowedSort::field('max_user_count'),


                AllowedSort::field('max_finger_count'),


                AllowedSort::field('max_attlog_count'),


                AllowedSort::field('alg_ver'),


                AllowedSort::field('flash_size'),


                AllowedSort::field('free_flash_size'),


                AllowedSort::field('language'),


                AllowedSort::field('lng_encode'),


                AllowedSort::field('volume'),


                AllowedSort::field('is_tft'),


                AllowedSort::field('platform'),


                AllowedSort::field('brightness'),


                AllowedSort::field('oem_vendor'),


                AllowedSort::field('city'),


                AllowedSort::field('AccFun'),


                AllowedSort::field('TZAdj'),


                AllowedSort::field('comm_type'),


                AllowedSort::field('agent_ipaddress'),


                AllowedSort::field('subnet_mask'),


                AllowedSort::field('gateway'),


                AllowedSort::field('area_id'),


                AllowedSort::field('acpanel_type'),


                AllowedSort::field('sync_time'),


                AllowedSort::field('four_to_two'),


                AllowedSort::field('video_login'),


                AllowedSort::field('fp_mthreshold'),


                AllowedSort::field('Fpversion'),


                AllowedSort::field('max_comm_size'),


                AllowedSort::field('max_comm_count'),


                AllowedSort::field('realtime'),


                AllowedSort::field('delay'),


                AllowedSort::field('encrypt'),


                AllowedSort::field('dstime_id'),


                AllowedSort::field('door_count'),


                AllowedSort::field('reader_count'),


                AllowedSort::field('aux_in_count'),


                AllowedSort::field('aux_out_count'),


                AllowedSort::field('IsOnlyRFMachine'),


                AllowedSort::field('alias'),


                AllowedSort::field('ipaddress'),


                AllowedSort::field('com_port'),


                AllowedSort::field('com_address'),


                AllowedSort::field('DeviceNetmask'),


                AllowedSort::field('DeviceGetway'),


                AllowedSort::field('SimpleEventType'),


                AllowedSort::field('FvFunOn'),


                AllowedSort::field('fvcount'),


                AllowedSort::field('deviceOption'),


                AllowedSort::field('DevSDKType'),


                AllowedSort::field('UTableDesc'),


                AllowedSort::field('IsTFTMachine'),


                AllowedSort::field('PinWidth'),


                AllowedSort::field('UserExtFmt'),


                AllowedSort::field('FP1_NThreshold'),


                AllowedSort::field('FP1_1Threshold'),


                AllowedSort::field('Face1_NThreshold'),


                AllowedSort::field('Face1_1Threshold'),


                AllowedSort::field('Only1_1Mode'),


                AllowedSort::field('OnlyCheckCard'),


                AllowedSort::field('MifireMustRegistered'),


                AllowedSort::field('RFCardOn'),


                AllowedSort::field('Mifire'),


                AllowedSort::field('MifireId'),


                AllowedSort::field('NetOn'),


                AllowedSort::field('RS232On'),


                AllowedSort::field('RS485On'),


                AllowedSort::field('FreeType'),


                AllowedSort::field('FreeTime'),


                AllowedSort::field('NoDisplayFun'),


                AllowedSort::field('VoiceTipsOn'),


                AllowedSort::field('TOMenu'),


                AllowedSort::field('StdVolume'),


                AllowedSort::field('VRYVH'),


                AllowedSort::field('KeyPadBeep'),


                AllowedSort::field('BatchUpdate'),


                AllowedSort::field('CardFun'),


                AllowedSort::field('FaceFunOn'),


                AllowedSort::field('FaceCount'),


                AllowedSort::field('TimeAPBFunOn'),


                AllowedSort::field('FingerFunOn'),


                AllowedSort::field('CompatOldFirmware'),


                AllowedSort::field('ParamValues'),


                AllowedSort::field('WirelessSSID'),


                AllowedSort::field('WirelessKey'),


                AllowedSort::field('WirelessAddr'),


                AllowedSort::field('WirelessMask'),


                AllowedSort::field('WirelessGateWay'),


                AllowedSort::field('IsWireless'),


                AllowedSort::field('ACFun'),


                AllowedSort::field('BiometricType'),


                AllowedSort::field('BiometricVersion'),


                AllowedSort::field('BiometricMaxCount'),


                AllowedSort::field('BiometricUsedCount'),


                AllowedSort::field('WIFI'),


                AllowedSort::field('WIFIOn'),


                AllowedSort::field('WIFIDHCP'),


                AllowedSort::field('IsExtend'),


                AllowedSort::field('identifiants_sadge'),


                AllowedSort::field('creat_by'),


            ])
            ->allowedIncludes([

            ]);

        if (!empty($_REQUEST["paginate"]) && $_REQUEST["paginate"] == 1) {
            $data = $data->paginate(isset($_REQUEST["limit"]) ? max(0, intval($_REQUEST["limit"])) : 20);
        } else {
            $data = $data->get();
        }
        $donnees = $data->toArray();


        if (!empty($donnees['data']) && is_array($donnees['data'])) {
            $new = [];
            foreach ($donnees['data'] as $response) {
                try {

                    foreach ($response['extra_attributes']["extra-data"] as $key => $dat) {
                        $response[$key] = $dat;
                    }
                    $response['extra_attributes'] = false;
                } catch (Throwable $e) {

                }
                $new[] = $response;
            }
            $donnees['data'] = $new;
        } else {

            foreach ($donnees as $response) {
                try {

                    foreach ($response['extra_attributes']["extra-data"] as $key => $dat) {
                        $response[$key] = $dat;
                    }
                    $response['extra_attributes'] = false;
                } catch (Throwable $e) {

                }
            }
        }


        return response()->json($donnees, 200);


//                        return response()->json($data,200);
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return Response
     */
    public function data1(Request $request)
    {


        $data = QueryBuilder::for(Machine::class)
            ->allowedFilters([
                AllowedFilter::exact('ID'),


                AllowedFilter::exact('MachineAlias'),


                AllowedFilter::exact('ConnectType'),


                AllowedFilter::exact('IP'),


                AllowedFilter::exact('SerialPort'),


                AllowedFilter::exact('Port'),


                AllowedFilter::exact('Baudrate'),


                AllowedFilter::exact('MachineNumber'),


                AllowedFilter::exact('IsHost'),


                AllowedFilter::exact('Enabled'),


                AllowedFilter::exact('CommPassword'),


                AllowedFilter::exact('UILanguage'),


                AllowedFilter::exact('DateFormat'),


                AllowedFilter::exact('InOutRecordWarn'),


                AllowedFilter::exact('Idle'),


                AllowedFilter::exact('Voice'),


                AllowedFilter::exact('managercount'),


                AllowedFilter::exact('usercount'),


                AllowedFilter::exact('fingercount'),


                AllowedFilter::exact('SecretCount'),


                AllowedFilter::exact('FirmwareVersion'),


                AllowedFilter::exact('ProductType'),


                AllowedFilter::exact('LockControl'),


                AllowedFilter::exact('Purpose'),


                AllowedFilter::exact('ProduceKind'),


                AllowedFilter::exact('sn'),


                AllowedFilter::exact('PhotoStamp'),


                AllowedFilter::exact('IsIfChangeConfigServer2'),


                AllowedFilter::exact('pushver'),


                AllowedFilter::exact('change_operator'),


                AllowedFilter::exact('change_time'),


                AllowedFilter::exact('create_operator'),


                AllowedFilter::exact('create_time'),


                AllowedFilter::exact('delete_operator'),


                AllowedFilter::exact('delete_time'),


                AllowedFilter::exact('status'),


                AllowedFilter::exact('device_type'),


                AllowedFilter::exact('last_activity'),


                AllowedFilter::exact('trans_times'),


                AllowedFilter::exact('TransInterval'),


                AllowedFilter::exact('log_stamp'),


                AllowedFilter::exact('oplog_stamp'),


                AllowedFilter::exact('photo_stamp'),


                AllowedFilter::exact('UpdateDB'),


                AllowedFilter::exact('device_name'),


                AllowedFilter::exact('transaction_count'),


                AllowedFilter::exact('main_time'),


                AllowedFilter::exact('max_user_count'),


                AllowedFilter::exact('max_finger_count'),


                AllowedFilter::exact('max_attlog_count'),


                AllowedFilter::exact('alg_ver'),


                AllowedFilter::exact('flash_size'),


                AllowedFilter::exact('free_flash_size'),


                AllowedFilter::exact('language'),


                AllowedFilter::exact('lng_encode'),


                AllowedFilter::exact('volume'),


                AllowedFilter::exact('is_tft'),


                AllowedFilter::exact('platform'),


                AllowedFilter::exact('brightness'),


                AllowedFilter::exact('oem_vendor'),


                AllowedFilter::exact('city'),


                AllowedFilter::exact('AccFun'),


                AllowedFilter::exact('TZAdj'),


                AllowedFilter::exact('comm_type'),


                AllowedFilter::exact('agent_ipaddress'),


                AllowedFilter::exact('subnet_mask'),


                AllowedFilter::exact('gateway'),


                AllowedFilter::exact('area_id'),


                AllowedFilter::exact('acpanel_type'),


                AllowedFilter::exact('sync_time'),


                AllowedFilter::exact('four_to_two'),


                AllowedFilter::exact('video_login'),


                AllowedFilter::exact('fp_mthreshold'),


                AllowedFilter::exact('Fpversion'),


                AllowedFilter::exact('max_comm_size'),


                AllowedFilter::exact('max_comm_count'),


                AllowedFilter::exact('realtime'),


                AllowedFilter::exact('delay'),


                AllowedFilter::exact('encrypt'),


                AllowedFilter::exact('dstime_id'),


                AllowedFilter::exact('door_count'),


                AllowedFilter::exact('reader_count'),


                AllowedFilter::exact('aux_in_count'),


                AllowedFilter::exact('aux_out_count'),


                AllowedFilter::exact('IsOnlyRFMachine'),


                AllowedFilter::exact('alias'),


                AllowedFilter::exact('ipaddress'),


                AllowedFilter::exact('com_port'),


                AllowedFilter::exact('com_address'),


                AllowedFilter::exact('DeviceNetmask'),


                AllowedFilter::exact('DeviceGetway'),


                AllowedFilter::exact('SimpleEventType'),


                AllowedFilter::exact('FvFunOn'),


                AllowedFilter::exact('fvcount'),


                AllowedFilter::exact('deviceOption'),


                AllowedFilter::exact('DevSDKType'),


                AllowedFilter::exact('UTableDesc'),


                AllowedFilter::exact('IsTFTMachine'),


                AllowedFilter::exact('PinWidth'),


                AllowedFilter::exact('UserExtFmt'),


                AllowedFilter::exact('FP1_NThreshold'),


                AllowedFilter::exact('FP1_1Threshold'),


                AllowedFilter::exact('Face1_NThreshold'),


                AllowedFilter::exact('Face1_1Threshold'),


                AllowedFilter::exact('Only1_1Mode'),


                AllowedFilter::exact('OnlyCheckCard'),


                AllowedFilter::exact('MifireMustRegistered'),


                AllowedFilter::exact('RFCardOn'),


                AllowedFilter::exact('Mifire'),


                AllowedFilter::exact('MifireId'),


                AllowedFilter::exact('NetOn'),


                AllowedFilter::exact('RS232On'),


                AllowedFilter::exact('RS485On'),


                AllowedFilter::exact('FreeType'),


                AllowedFilter::exact('FreeTime'),


                AllowedFilter::exact('NoDisplayFun'),


                AllowedFilter::exact('VoiceTipsOn'),


                AllowedFilter::exact('TOMenu'),


                AllowedFilter::exact('StdVolume'),


                AllowedFilter::exact('VRYVH'),


                AllowedFilter::exact('KeyPadBeep'),


                AllowedFilter::exact('BatchUpdate'),


                AllowedFilter::exact('CardFun'),


                AllowedFilter::exact('FaceFunOn'),


                AllowedFilter::exact('FaceCount'),


                AllowedFilter::exact('TimeAPBFunOn'),


                AllowedFilter::exact('FingerFunOn'),


                AllowedFilter::exact('CompatOldFirmware'),


                AllowedFilter::exact('ParamValues'),


                AllowedFilter::exact('WirelessSSID'),


                AllowedFilter::exact('WirelessKey'),


                AllowedFilter::exact('WirelessAddr'),


                AllowedFilter::exact('WirelessMask'),


                AllowedFilter::exact('WirelessGateWay'),


                AllowedFilter::exact('IsWireless'),


                AllowedFilter::exact('ACFun'),


                AllowedFilter::exact('BiometricType'),


                AllowedFilter::exact('BiometricVersion'),


                AllowedFilter::exact('BiometricMaxCount'),


                AllowedFilter::exact('BiometricUsedCount'),


                AllowedFilter::exact('WIFI'),


                AllowedFilter::exact('WIFIOn'),


                AllowedFilter::exact('WIFIDHCP'),


                AllowedFilter::exact('IsExtend'),


                AllowedFilter::exact('identifiants_sadge'),


                AllowedFilter::exact('creat_by'),


                AllowedFilter::callback('not_null', function (Builder $query, $value) {
//                    dump($value);

                    if (!is_array($value)) {
                        $value = explode(',', $value);
                    }
                    foreach ($value as $val) {
                        $query->whereNotNull($val);

                    }


                    return $query;
                }),
                AllowedFilter::callback('null', function (Builder $query, $value) {
//                    dump($value);
                    if (!is_array($value)) {
                        $value = explode(',', $value);
                    }


                    foreach ($value as $val) {
                        $query->whereNull($val);

                    }


                    return $query;
                }),
                AllowedFilter::callback('date', function (Builder $query, $value) {
//                    dd($value);


                    if (!is_array($value)) {
                        $value = explode(',', $value);
                    }
                    foreach ($value as $val) {
                        $dat = explode('/', $val);
                        if (count($dat) == 3) {
                            if ($dat[1] != 'like') {
                                $query->where($dat[0], $dat[1], Carbon::parse($dat[2]));

                            } else {

                                $query->where($dat[0], "LIKE", "%" . $dat[2] . "%");
                            }
//                                dd($dat,$dat[0],Carbon::parse($dat[2]));

                        }

                    }


                    return $query;
                }),

                AllowedFilter::callback('like', function (Builder $query, $value) {
                    if (!is_array($value)) {
                        $value = explode(',', $value);
                    }

                    foreach ($value as $val) {
                        $dat = explode('/', $val);
                        if (count($dat) == 2) {
                            $query->where($dat[0], "LIKE", "%" . $dat[1] . "%");

                        }

                    }


                    return $query;
                }),
                AllowedFilter::callback('where', function (Builder $query, $value) {
                    if (!is_array($value)) {
                        $value = explode(',', $value);
                    }

                    foreach ($value as $val) {
                        $dat = explode('/', $val);
                        if (count($dat) == 3) {
                            $query->where($dat[0], $dat[1], $dat[2]);

                        }

                    }


                    return $query;
                }),
            ])
            ->allowedSorts([
                AllowedSort::field('ID'),


                AllowedSort::field('MachineAlias'),


                AllowedSort::field('ConnectType'),


                AllowedSort::field('IP'),


                AllowedSort::field('SerialPort'),


                AllowedSort::field('Port'),


                AllowedSort::field('Baudrate'),


                AllowedSort::field('MachineNumber'),


                AllowedSort::field('IsHost'),


                AllowedSort::field('Enabled'),


                AllowedSort::field('CommPassword'),


                AllowedSort::field('UILanguage'),


                AllowedSort::field('DateFormat'),


                AllowedSort::field('InOutRecordWarn'),


                AllowedSort::field('Idle'),


                AllowedSort::field('Voice'),


                AllowedSort::field('managercount'),


                AllowedSort::field('usercount'),


                AllowedSort::field('fingercount'),


                AllowedSort::field('SecretCount'),


                AllowedSort::field('FirmwareVersion'),


                AllowedSort::field('ProductType'),


                AllowedSort::field('LockControl'),


                AllowedSort::field('Purpose'),


                AllowedSort::field('ProduceKind'),


                AllowedSort::field('sn'),


                AllowedSort::field('PhotoStamp'),


                AllowedSort::field('IsIfChangeConfigServer2'),


                AllowedSort::field('pushver'),


                AllowedSort::field('change_operator'),


                AllowedSort::field('change_time'),


                AllowedSort::field('create_operator'),


                AllowedSort::field('create_time'),


                AllowedSort::field('delete_operator'),


                AllowedSort::field('delete_time'),


                AllowedSort::field('status'),


                AllowedSort::field('device_type'),


                AllowedSort::field('last_activity'),


                AllowedSort::field('trans_times'),


                AllowedSort::field('TransInterval'),


                AllowedSort::field('log_stamp'),


                AllowedSort::field('oplog_stamp'),


                AllowedSort::field('photo_stamp'),


                AllowedSort::field('UpdateDB'),


                AllowedSort::field('device_name'),


                AllowedSort::field('transaction_count'),


                AllowedSort::field('main_time'),


                AllowedSort::field('max_user_count'),


                AllowedSort::field('max_finger_count'),


                AllowedSort::field('max_attlog_count'),


                AllowedSort::field('alg_ver'),


                AllowedSort::field('flash_size'),


                AllowedSort::field('free_flash_size'),


                AllowedSort::field('language'),


                AllowedSort::field('lng_encode'),


                AllowedSort::field('volume'),


                AllowedSort::field('is_tft'),


                AllowedSort::field('platform'),


                AllowedSort::field('brightness'),


                AllowedSort::field('oem_vendor'),


                AllowedSort::field('city'),


                AllowedSort::field('AccFun'),


                AllowedSort::field('TZAdj'),


                AllowedSort::field('comm_type'),


                AllowedSort::field('agent_ipaddress'),


                AllowedSort::field('subnet_mask'),


                AllowedSort::field('gateway'),


                AllowedSort::field('area_id'),


                AllowedSort::field('acpanel_type'),


                AllowedSort::field('sync_time'),


                AllowedSort::field('four_to_two'),


                AllowedSort::field('video_login'),


                AllowedSort::field('fp_mthreshold'),


                AllowedSort::field('Fpversion'),


                AllowedSort::field('max_comm_size'),


                AllowedSort::field('max_comm_count'),


                AllowedSort::field('realtime'),


                AllowedSort::field('delay'),


                AllowedSort::field('encrypt'),


                AllowedSort::field('dstime_id'),


                AllowedSort::field('door_count'),


                AllowedSort::field('reader_count'),


                AllowedSort::field('aux_in_count'),


                AllowedSort::field('aux_out_count'),


                AllowedSort::field('IsOnlyRFMachine'),


                AllowedSort::field('alias'),


                AllowedSort::field('ipaddress'),


                AllowedSort::field('com_port'),


                AllowedSort::field('com_address'),


                AllowedSort::field('DeviceNetmask'),


                AllowedSort::field('DeviceGetway'),


                AllowedSort::field('SimpleEventType'),


                AllowedSort::field('FvFunOn'),


                AllowedSort::field('fvcount'),


                AllowedSort::field('deviceOption'),


                AllowedSort::field('DevSDKType'),


                AllowedSort::field('UTableDesc'),


                AllowedSort::field('IsTFTMachine'),


                AllowedSort::field('PinWidth'),


                AllowedSort::field('UserExtFmt'),


                AllowedSort::field('FP1_NThreshold'),


                AllowedSort::field('FP1_1Threshold'),


                AllowedSort::field('Face1_NThreshold'),


                AllowedSort::field('Face1_1Threshold'),


                AllowedSort::field('Only1_1Mode'),


                AllowedSort::field('OnlyCheckCard'),


                AllowedSort::field('MifireMustRegistered'),


                AllowedSort::field('RFCardOn'),


                AllowedSort::field('Mifire'),


                AllowedSort::field('MifireId'),


                AllowedSort::field('NetOn'),


                AllowedSort::field('RS232On'),


                AllowedSort::field('RS485On'),


                AllowedSort::field('FreeType'),


                AllowedSort::field('FreeTime'),


                AllowedSort::field('NoDisplayFun'),


                AllowedSort::field('VoiceTipsOn'),


                AllowedSort::field('TOMenu'),


                AllowedSort::field('StdVolume'),


                AllowedSort::field('VRYVH'),


                AllowedSort::field('KeyPadBeep'),


                AllowedSort::field('BatchUpdate'),


                AllowedSort::field('CardFun'),


                AllowedSort::field('FaceFunOn'),


                AllowedSort::field('FaceCount'),


                AllowedSort::field('TimeAPBFunOn'),


                AllowedSort::field('FingerFunOn'),


                AllowedSort::field('CompatOldFirmware'),


                AllowedSort::field('ParamValues'),


                AllowedSort::field('WirelessSSID'),


                AllowedSort::field('WirelessKey'),


                AllowedSort::field('WirelessAddr'),


                AllowedSort::field('WirelessMask'),


                AllowedSort::field('WirelessGateWay'),


                AllowedSort::field('IsWireless'),


                AllowedSort::field('ACFun'),


                AllowedSort::field('BiometricType'),


                AllowedSort::field('BiometricVersion'),


                AllowedSort::field('BiometricMaxCount'),


                AllowedSort::field('BiometricUsedCount'),


                AllowedSort::field('WIFI'),


                AllowedSort::field('WIFIOn'),


                AllowedSort::field('WIFIDHCP'),


                AllowedSort::field('IsExtend'),


                AllowedSort::field('identifiants_sadge'),


                AllowedSort::field('creat_by'),


            ])
            ->allowedIncludes([
            ]);

        if (!empty($_REQUEST["count"]) && $_REQUEST["count"] == 1) {
            return response()->json($data->count());
        }

        if (!empty($_REQUEST["paginate"]) && $_REQUEST["paginate"] == 1) {
            $data = $data->paginate(isset($_REQUEST["limit"]) ? max(0, intval($_REQUEST["limit"])) : 20);
        } else {
            $data = $data->get();
        }
        $donnees = $data->toArray();


        if (!empty($donnees['data']) && is_array($donnees['data'])) {
            $new = [];
            foreach ($donnees['data'] as $response) {
                try {

                    foreach ($response['extra_attributes']["extra-data"] as $key => $dat) {
                        $response[$key] = $dat;
                    }
                    $response['extra_attributes'] = false;
                } catch (Throwable $e) {

                }
                $new[] = $response;
            }
            $donnees['data'] = $new;
        } else {

            foreach ($donnees as $response) {
                try {

                    foreach ($response['extra_attributes']["extra-data"] as $key => $dat) {
                        $response[$key] = $dat;
                    }
                    $response['extra_attributes'] = false;
                } catch (Throwable $e) {

                }
            }
        }


        return response()->json($donnees, 200);


//                        return response()->json($data,200);
    }


    public function create(Request $request, Machine $Machines)
    {


        try {
            $can = Helpers::can('Creer des Machines');

            if (!$can) {
                return response()->json([], 200);
            }
        } catch (Throwable $e) {
        }


        $data = $request->all();
        foreach ($request->allFiles() as $key => $file) {
            $path = $file->storeAs(
                'storage/uploads', "Machines" . "-" . $key . "_" . time() . "." . $file->extension()
            );
            $data[$key] = $path;
        }


        $champsRechercher = [
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
        $envoyer = [];
        foreach ($data as $key => $d) {
            $envoyer[] = $key;


        }
        $envoyer = array_unique($envoyer);

        Validator::make($data, [

            'ID' => [
                //'required'
            ],


            'MachineAlias' => [
                //'required'
            ],


            'ConnectType' => [
                //'required'
            ],


            'IP' => [
                //'required'
            ],


            'SerialPort' => [
                //'required'
            ],


            'Port' => [
                //'required'
            ],


            'Baudrate' => [
                //'required'
            ],


            'MachineNumber' => [
                //'required'
            ],


            'IsHost' => [
                //'required'
            ],


            'Enabled' => [
                //'required'
            ],


            'CommPassword' => [
                //'required'
            ],


            'UILanguage' => [
                //'required'
            ],


            'DateFormat' => [
                //'required'
            ],


            'InOutRecordWarn' => [
                //'required'
            ],


            'Idle' => [
                //'required'
            ],


            'Voice' => [
                //'required'
            ],


            'managercount' => [
                //'required'
            ],


            'usercount' => [
                //'required'
            ],


            'fingercount' => [
                //'required'
            ],


            'SecretCount' => [
                //'required'
            ],


            'FirmwareVersion' => [
                //'required'
            ],


            'ProductType' => [
                //'required'
            ],


            'LockControl' => [
                //'required'
            ],


            'Purpose' => [
                //'required'
            ],


            'ProduceKind' => [
                //'required'
            ],


            'sn' => [
                //'required'
            ],


            'PhotoStamp' => [
                //'required'
            ],


            'IsIfChangeConfigServer2' => [
                //'required'
            ],


            'pushver' => [
                //'required'
            ],


            'change_operator' => [
                //'required'
            ],


            'change_time' => [
                //'required'
            ],


            'create_operator' => [
                //'required'
            ],


            'create_time' => [
                //'required'
            ],


            'delete_operator' => [
                //'required'
            ],


            'delete_time' => [
                //'required'
            ],


            'status' => [
                //'required'
            ],


            'device_type' => [
                //'required'
            ],


            'last_activity' => [
                //'required'
            ],


            'trans_times' => [
                //'required'
            ],


            'TransInterval' => [
                //'required'
            ],


            'log_stamp' => [
                //'required'
            ],


            'oplog_stamp' => [
                //'required'
            ],


            'photo_stamp' => [
                //'required'
            ],


            'UpdateDB' => [
                //'required'
            ],


            'device_name' => [
                //'required'
            ],


            'transaction_count' => [
                //'required'
            ],


            'main_time' => [
                //'required'
            ],


            'max_user_count' => [
                //'required'
            ],


            'max_finger_count' => [
                //'required'
            ],


            'max_attlog_count' => [
                //'required'
            ],


            'alg_ver' => [
                //'required'
            ],


            'flash_size' => [
                //'required'
            ],


            'free_flash_size' => [
                //'required'
            ],


            'language' => [
                //'required'
            ],


            'lng_encode' => [
                //'required'
            ],


            'volume' => [
                //'required'
            ],


            'is_tft' => [
                //'required'
            ],


            'platform' => [
                //'required'
            ],


            'brightness' => [
                //'required'
            ],


            'oem_vendor' => [
                //'required'
            ],


            'city' => [
                //'required'
            ],


            'AccFun' => [
                //'required'
            ],


            'TZAdj' => [
                //'required'
            ],


            'comm_type' => [
                //'required'
            ],


            'agent_ipaddress' => [
                //'required'
            ],


            'subnet_mask' => [
                //'required'
            ],


            'gateway' => [
                //'required'
            ],


            'area_id' => [
                //'required'
            ],


            'acpanel_type' => [
                //'required'
            ],


            'sync_time' => [
                //'required'
            ],


            'four_to_two' => [
                //'required'
            ],


            'video_login' => [
                //'required'
            ],


            'fp_mthreshold' => [
                //'required'
            ],


            'Fpversion' => [
                //'required'
            ],


            'max_comm_size' => [
                //'required'
            ],


            'max_comm_count' => [
                //'required'
            ],


            'realtime' => [
                //'required'
            ],


            'delay' => [
                //'required'
            ],


            'encrypt' => [
                //'required'
            ],


            'dstime_id' => [
                //'required'
            ],


            'door_count' => [
                //'required'
            ],


            'reader_count' => [
                //'required'
            ],


            'aux_in_count' => [
                //'required'
            ],


            'aux_out_count' => [
                //'required'
            ],


            'IsOnlyRFMachine' => [
                //'required'
            ],


            'alias' => [
                //'required'
            ],


            'ipaddress' => [
                //'required'
            ],


            'com_port' => [
                //'required'
            ],


            'com_address' => [
                //'required'
            ],


            'DeviceNetmask' => [
                //'required'
            ],


            'DeviceGetway' => [
                //'required'
            ],


            'SimpleEventType' => [
                //'required'
            ],


            'FvFunOn' => [
                //'required'
            ],


            'fvcount' => [
                //'required'
            ],


            'deviceOption' => [
                //'required'
            ],


            'DevSDKType' => [
                //'required'
            ],


            'UTableDesc' => [
                //'required'
            ],


            'IsTFTMachine' => [
                //'required'
            ],


            'PinWidth' => [
                //'required'
            ],


            'UserExtFmt' => [
                //'required'
            ],


            'FP1_NThreshold' => [
                //'required'
            ],


            'FP1_1Threshold' => [
                //'required'
            ],


            'Face1_NThreshold' => [
                //'required'
            ],


            'Face1_1Threshold' => [
                //'required'
            ],


            'Only1_1Mode' => [
                //'required'
            ],


            'OnlyCheckCard' => [
                //'required'
            ],


            'MifireMustRegistered' => [
                //'required'
            ],


            'RFCardOn' => [
                //'required'
            ],


            'Mifire' => [
                //'required'
            ],


            'MifireId' => [
                //'required'
            ],


            'NetOn' => [
                //'required'
            ],


            'RS232On' => [
                //'required'
            ],


            'RS485On' => [
                //'required'
            ],


            'FreeType' => [
                //'required'
            ],


            'FreeTime' => [
                //'required'
            ],


            'NoDisplayFun' => [
                //'required'
            ],


            'VoiceTipsOn' => [
                //'required'
            ],


            'TOMenu' => [
                //'required'
            ],


            'StdVolume' => [
                //'required'
            ],


            'VRYVH' => [
                //'required'
            ],


            'KeyPadBeep' => [
                //'required'
            ],


            'BatchUpdate' => [
                //'required'
            ],


            'CardFun' => [
                //'required'
            ],


            'FaceFunOn' => [
                //'required'
            ],


            'FaceCount' => [
                //'required'
            ],


            'TimeAPBFunOn' => [
                //'required'
            ],


            'FingerFunOn' => [
                //'required'
            ],


            'CompatOldFirmware' => [
                //'required'
            ],


            'ParamValues' => [
                //'required'
            ],


            'WirelessSSID' => [
                //'required'
            ],


            'WirelessKey' => [
                //'required'
            ],


            'WirelessAddr' => [
                //'required'
            ],


            'WirelessMask' => [
                //'required'
            ],


            'WirelessGateWay' => [
                //'required'
            ],


            'IsWireless' => [
                //'required'
            ],


            'ACFun' => [
                //'required'
            ],


            'BiometricType' => [
                //'required'
            ],


            'BiometricVersion' => [
                //'required'
            ],


            'BiometricMaxCount' => [
                //'required'
            ],


            'BiometricUsedCount' => [
                //'required'
            ],


            'WIFI' => [
                //'required'
            ],


            'WIFIOn' => [
                //'required'
            ],


            'WIFIDHCP' => [
                //'required'
            ],


            'IsExtend' => [
                //'required'
            ],


            'identifiants_sadge' => [
                //'required'
            ],


            'creat_by' => [
                //'required'
            ],


        ], $messages = [


            'ID' => ['cette donnee est obligatoire'],


            'MachineAlias' => ['cette donnee est obligatoire'],


            'ConnectType' => ['cette donnee est obligatoire'],


            'IP' => ['cette donnee est obligatoire'],


            'SerialPort' => ['cette donnee est obligatoire'],


            'Port' => ['cette donnee est obligatoire'],


            'Baudrate' => ['cette donnee est obligatoire'],


            'MachineNumber' => ['cette donnee est obligatoire'],


            'IsHost' => ['cette donnee est obligatoire'],


            'Enabled' => ['cette donnee est obligatoire'],


            'CommPassword' => ['cette donnee est obligatoire'],


            'UILanguage' => ['cette donnee est obligatoire'],


            'DateFormat' => ['cette donnee est obligatoire'],


            'InOutRecordWarn' => ['cette donnee est obligatoire'],


            'Idle' => ['cette donnee est obligatoire'],


            'Voice' => ['cette donnee est obligatoire'],


            'managercount' => ['cette donnee est obligatoire'],


            'usercount' => ['cette donnee est obligatoire'],


            'fingercount' => ['cette donnee est obligatoire'],


            'SecretCount' => ['cette donnee est obligatoire'],


            'FirmwareVersion' => ['cette donnee est obligatoire'],


            'ProductType' => ['cette donnee est obligatoire'],


            'LockControl' => ['cette donnee est obligatoire'],


            'Purpose' => ['cette donnee est obligatoire'],


            'ProduceKind' => ['cette donnee est obligatoire'],


            'sn' => ['cette donnee est obligatoire'],


            'PhotoStamp' => ['cette donnee est obligatoire'],


            'IsIfChangeConfigServer2' => ['cette donnee est obligatoire'],


            'pushver' => ['cette donnee est obligatoire'],


            'change_operator' => ['cette donnee est obligatoire'],


            'change_time' => ['cette donnee est obligatoire'],


            'create_operator' => ['cette donnee est obligatoire'],


            'create_time' => ['cette donnee est obligatoire'],


            'delete_operator' => ['cette donnee est obligatoire'],


            'delete_time' => ['cette donnee est obligatoire'],


            'status' => ['cette donnee est obligatoire'],


            'device_type' => ['cette donnee est obligatoire'],


            'last_activity' => ['cette donnee est obligatoire'],


            'trans_times' => ['cette donnee est obligatoire'],


            'TransInterval' => ['cette donnee est obligatoire'],


            'log_stamp' => ['cette donnee est obligatoire'],


            'oplog_stamp' => ['cette donnee est obligatoire'],


            'photo_stamp' => ['cette donnee est obligatoire'],


            'UpdateDB' => ['cette donnee est obligatoire'],


            'device_name' => ['cette donnee est obligatoire'],


            'transaction_count' => ['cette donnee est obligatoire'],


            'main_time' => ['cette donnee est obligatoire'],


            'max_user_count' => ['cette donnee est obligatoire'],


            'max_finger_count' => ['cette donnee est obligatoire'],


            'max_attlog_count' => ['cette donnee est obligatoire'],


            'alg_ver' => ['cette donnee est obligatoire'],


            'flash_size' => ['cette donnee est obligatoire'],


            'free_flash_size' => ['cette donnee est obligatoire'],


            'language' => ['cette donnee est obligatoire'],


            'lng_encode' => ['cette donnee est obligatoire'],


            'volume' => ['cette donnee est obligatoire'],


            'is_tft' => ['cette donnee est obligatoire'],


            'platform' => ['cette donnee est obligatoire'],


            'brightness' => ['cette donnee est obligatoire'],


            'oem_vendor' => ['cette donnee est obligatoire'],


            'city' => ['cette donnee est obligatoire'],


            'AccFun' => ['cette donnee est obligatoire'],


            'TZAdj' => ['cette donnee est obligatoire'],


            'comm_type' => ['cette donnee est obligatoire'],


            'agent_ipaddress' => ['cette donnee est obligatoire'],


            'subnet_mask' => ['cette donnee est obligatoire'],


            'gateway' => ['cette donnee est obligatoire'],


            'area_id' => ['cette donnee est obligatoire'],


            'acpanel_type' => ['cette donnee est obligatoire'],


            'sync_time' => ['cette donnee est obligatoire'],


            'four_to_two' => ['cette donnee est obligatoire'],


            'video_login' => ['cette donnee est obligatoire'],


            'fp_mthreshold' => ['cette donnee est obligatoire'],


            'Fpversion' => ['cette donnee est obligatoire'],


            'max_comm_size' => ['cette donnee est obligatoire'],


            'max_comm_count' => ['cette donnee est obligatoire'],


            'realtime' => ['cette donnee est obligatoire'],


            'delay' => ['cette donnee est obligatoire'],


            'encrypt' => ['cette donnee est obligatoire'],


            'dstime_id' => ['cette donnee est obligatoire'],


            'door_count' => ['cette donnee est obligatoire'],


            'reader_count' => ['cette donnee est obligatoire'],


            'aux_in_count' => ['cette donnee est obligatoire'],


            'aux_out_count' => ['cette donnee est obligatoire'],


            'IsOnlyRFMachine' => ['cette donnee est obligatoire'],


            'alias' => ['cette donnee est obligatoire'],


            'ipaddress' => ['cette donnee est obligatoire'],


            'com_port' => ['cette donnee est obligatoire'],


            'com_address' => ['cette donnee est obligatoire'],


            'DeviceNetmask' => ['cette donnee est obligatoire'],


            'DeviceGetway' => ['cette donnee est obligatoire'],


            'SimpleEventType' => ['cette donnee est obligatoire'],


            'FvFunOn' => ['cette donnee est obligatoire'],


            'fvcount' => ['cette donnee est obligatoire'],


            'deviceOption' => ['cette donnee est obligatoire'],


            'DevSDKType' => ['cette donnee est obligatoire'],


            'UTableDesc' => ['cette donnee est obligatoire'],


            'IsTFTMachine' => ['cette donnee est obligatoire'],


            'PinWidth' => ['cette donnee est obligatoire'],


            'UserExtFmt' => ['cette donnee est obligatoire'],


            'FP1_NThreshold' => ['cette donnee est obligatoire'],


            'FP1_1Threshold' => ['cette donnee est obligatoire'],


            'Face1_NThreshold' => ['cette donnee est obligatoire'],


            'Face1_1Threshold' => ['cette donnee est obligatoire'],


            'Only1_1Mode' => ['cette donnee est obligatoire'],


            'OnlyCheckCard' => ['cette donnee est obligatoire'],


            'MifireMustRegistered' => ['cette donnee est obligatoire'],


            'RFCardOn' => ['cette donnee est obligatoire'],


            'Mifire' => ['cette donnee est obligatoire'],


            'MifireId' => ['cette donnee est obligatoire'],


            'NetOn' => ['cette donnee est obligatoire'],


            'RS232On' => ['cette donnee est obligatoire'],


            'RS485On' => ['cette donnee est obligatoire'],


            'FreeType' => ['cette donnee est obligatoire'],


            'FreeTime' => ['cette donnee est obligatoire'],


            'NoDisplayFun' => ['cette donnee est obligatoire'],


            'VoiceTipsOn' => ['cette donnee est obligatoire'],


            'TOMenu' => ['cette donnee est obligatoire'],


            'StdVolume' => ['cette donnee est obligatoire'],


            'VRYVH' => ['cette donnee est obligatoire'],


            'KeyPadBeep' => ['cette donnee est obligatoire'],


            'BatchUpdate' => ['cette donnee est obligatoire'],


            'CardFun' => ['cette donnee est obligatoire'],


            'FaceFunOn' => ['cette donnee est obligatoire'],


            'FaceCount' => ['cette donnee est obligatoire'],


            'TimeAPBFunOn' => ['cette donnee est obligatoire'],


            'FingerFunOn' => ['cette donnee est obligatoire'],


            'CompatOldFirmware' => ['cette donnee est obligatoire'],


            'ParamValues' => ['cette donnee est obligatoire'],


            'WirelessSSID' => ['cette donnee est obligatoire'],


            'WirelessKey' => ['cette donnee est obligatoire'],


            'WirelessAddr' => ['cette donnee est obligatoire'],


            'WirelessMask' => ['cette donnee est obligatoire'],


            'WirelessGateWay' => ['cette donnee est obligatoire'],


            'IsWireless' => ['cette donnee est obligatoire'],


            'ACFun' => ['cette donnee est obligatoire'],


            'BiometricType' => ['cette donnee est obligatoire'],


            'BiometricVersion' => ['cette donnee est obligatoire'],


            'BiometricMaxCount' => ['cette donnee est obligatoire'],


            'BiometricUsedCount' => ['cette donnee est obligatoire'],


            'WIFI' => ['cette donnee est obligatoire'],


            'WIFIOn' => ['cette donnee est obligatoire'],


            'WIFIDHCP' => ['cette donnee est obligatoire'],


            'IsExtend' => ['cette donnee est obligatoire'],


            'identifiants_sadge' => ['cette donnee est obligatoire'],


            'creat_by' => ['cette donnee est obligatoire'],


        ])->validate();


        $extra_data = array_diff($envoyer, $champsRechercher);

        $data['creat_by'] = Auth::id();


        if (!empty($data['ID'])) {

            $Machines->ID = $data['ID'];

        }


        if (!empty($data['MachineAlias'])) {

            $Machines->MachineAlias = $data['MachineAlias'];

        }


        if (!empty($data['ConnectType'])) {

            $Machines->ConnectType = $data['ConnectType'];

        }


        if (!empty($data['IP'])) {

            $Machines->IP = $data['IP'];

        }


        if (!empty($data['SerialPort'])) {

            $Machines->SerialPort = $data['SerialPort'];

        }


        if (!empty($data['Port'])) {

            $Machines->Port = $data['Port'];

        }


        if (!empty($data['Baudrate'])) {

            $Machines->Baudrate = $data['Baudrate'];

        }


        if (!empty($data['MachineNumber'])) {

            $Machines->MachineNumber = $data['MachineNumber'];

        }


        if (!empty($data['IsHost'])) {

            $Machines->IsHost = $data['IsHost'];

        }


        if (!empty($data['Enabled'])) {

            $Machines->Enabled = $data['Enabled'];

        }


        if (!empty($data['CommPassword'])) {

            $Machines->CommPassword = $data['CommPassword'];

        }


        if (!empty($data['UILanguage'])) {

            $Machines->UILanguage = $data['UILanguage'];

        }


        if (!empty($data['DateFormat'])) {

            $Machines->DateFormat = $data['DateFormat'];

        }


        if (!empty($data['InOutRecordWarn'])) {

            $Machines->InOutRecordWarn = $data['InOutRecordWarn'];

        }


        if (!empty($data['Idle'])) {

            $Machines->Idle = $data['Idle'];

        }


        if (!empty($data['Voice'])) {

            $Machines->Voice = $data['Voice'];

        }


        if (!empty($data['managercount'])) {

            $Machines->managercount = $data['managercount'];

        }


        if (!empty($data['usercount'])) {

            $Machines->usercount = $data['usercount'];

        }


        if (!empty($data['fingercount'])) {

            $Machines->fingercount = $data['fingercount'];

        }


        if (!empty($data['SecretCount'])) {

            $Machines->SecretCount = $data['SecretCount'];

        }


        if (!empty($data['FirmwareVersion'])) {

            $Machines->FirmwareVersion = $data['FirmwareVersion'];

        }


        if (!empty($data['ProductType'])) {

            $Machines->ProductType = $data['ProductType'];

        }


        if (!empty($data['LockControl'])) {

            $Machines->LockControl = $data['LockControl'];

        }


        if (!empty($data['Purpose'])) {

            $Machines->Purpose = $data['Purpose'];

        }


        if (!empty($data['ProduceKind'])) {

            $Machines->ProduceKind = $data['ProduceKind'];

        }


        if (!empty($data['sn'])) {

            $Machines->sn = $data['sn'];

        }


        if (!empty($data['PhotoStamp'])) {

            $Machines->PhotoStamp = $data['PhotoStamp'];

        }


        if (!empty($data['IsIfChangeConfigServer2'])) {

            $Machines->IsIfChangeConfigServer2 = $data['IsIfChangeConfigServer2'];

        }


        if (!empty($data['pushver'])) {

            $Machines->pushver = $data['pushver'];

        }


        if (!empty($data['change_operator'])) {

            $Machines->change_operator = $data['change_operator'];

        }


        if (!empty($data['change_time'])) {

            $Machines->change_time = $data['change_time'];

        }


        if (!empty($data['create_operator'])) {

            $Machines->create_operator = $data['create_operator'];

        }


        if (!empty($data['create_time'])) {

            $Machines->create_time = $data['create_time'];

        }


        if (!empty($data['delete_operator'])) {

            $Machines->delete_operator = $data['delete_operator'];

        }


        if (!empty($data['delete_time'])) {

            $Machines->delete_time = $data['delete_time'];

        }


        if (!empty($data['status'])) {

            $Machines->status = $data['status'];

        }


        if (!empty($data['device_type'])) {

            $Machines->device_type = $data['device_type'];

        }


        if (!empty($data['last_activity'])) {

            $Machines->last_activity = $data['last_activity'];

        }


        if (!empty($data['trans_times'])) {

            $Machines->trans_times = $data['trans_times'];

        }


        if (!empty($data['TransInterval'])) {

            $Machines->TransInterval = $data['TransInterval'];

        }


        if (!empty($data['log_stamp'])) {

            $Machines->log_stamp = $data['log_stamp'];

        }


        if (!empty($data['oplog_stamp'])) {

            $Machines->oplog_stamp = $data['oplog_stamp'];

        }


        if (!empty($data['photo_stamp'])) {

            $Machines->photo_stamp = $data['photo_stamp'];

        }


        if (!empty($data['UpdateDB'])) {

            $Machines->UpdateDB = $data['UpdateDB'];

        }


        if (!empty($data['device_name'])) {

            $Machines->device_name = $data['device_name'];

        }


        if (!empty($data['transaction_count'])) {

            $Machines->transaction_count = $data['transaction_count'];

        }


        if (!empty($data['main_time'])) {

            $Machines->main_time = $data['main_time'];

        }


        if (!empty($data['max_user_count'])) {

            $Machines->max_user_count = $data['max_user_count'];

        }


        if (!empty($data['max_finger_count'])) {

            $Machines->max_finger_count = $data['max_finger_count'];

        }


        if (!empty($data['max_attlog_count'])) {

            $Machines->max_attlog_count = $data['max_attlog_count'];

        }


        if (!empty($data['alg_ver'])) {

            $Machines->alg_ver = $data['alg_ver'];

        }


        if (!empty($data['flash_size'])) {

            $Machines->flash_size = $data['flash_size'];

        }


        if (!empty($data['free_flash_size'])) {

            $Machines->free_flash_size = $data['free_flash_size'];

        }


        if (!empty($data['language'])) {

            $Machines->language = $data['language'];

        }


        if (!empty($data['lng_encode'])) {

            $Machines->lng_encode = $data['lng_encode'];

        }


        if (!empty($data['volume'])) {

            $Machines->volume = $data['volume'];

        }


        if (!empty($data['is_tft'])) {

            $Machines->is_tft = $data['is_tft'];

        }


        if (!empty($data['platform'])) {

            $Machines->platform = $data['platform'];

        }


        if (!empty($data['brightness'])) {

            $Machines->brightness = $data['brightness'];

        }


        if (!empty($data['oem_vendor'])) {

            $Machines->oem_vendor = $data['oem_vendor'];

        }


        if (!empty($data['city'])) {

            $Machines->city = $data['city'];

        }


        if (!empty($data['AccFun'])) {

            $Machines->AccFun = $data['AccFun'];

        }


        if (!empty($data['TZAdj'])) {

            $Machines->TZAdj = $data['TZAdj'];

        }


        if (!empty($data['comm_type'])) {

            $Machines->comm_type = $data['comm_type'];

        }


        if (!empty($data['agent_ipaddress'])) {

            $Machines->agent_ipaddress = $data['agent_ipaddress'];

        }


        if (!empty($data['subnet_mask'])) {

            $Machines->subnet_mask = $data['subnet_mask'];

        }


        if (!empty($data['gateway'])) {

            $Machines->gateway = $data['gateway'];

        }


        if (!empty($data['area_id'])) {

            $Machines->area_id = $data['area_id'];

        }


        if (!empty($data['acpanel_type'])) {

            $Machines->acpanel_type = $data['acpanel_type'];

        }


        if (!empty($data['sync_time'])) {

            $Machines->sync_time = $data['sync_time'];

        }


        if (!empty($data['four_to_two'])) {

            $Machines->four_to_two = $data['four_to_two'];

        }


        if (!empty($data['video_login'])) {

            $Machines->video_login = $data['video_login'];

        }


        if (!empty($data['fp_mthreshold'])) {

            $Machines->fp_mthreshold = $data['fp_mthreshold'];

        }


        if (!empty($data['Fpversion'])) {

            $Machines->Fpversion = $data['Fpversion'];

        }


        if (!empty($data['max_comm_size'])) {

            $Machines->max_comm_size = $data['max_comm_size'];

        }


        if (!empty($data['max_comm_count'])) {

            $Machines->max_comm_count = $data['max_comm_count'];

        }


        if (!empty($data['realtime'])) {

            $Machines->realtime = $data['realtime'];

        }


        if (!empty($data['delay'])) {

            $Machines->delay = $data['delay'];

        }


        if (!empty($data['encrypt'])) {

            $Machines->encrypt = $data['encrypt'];

        }


        if (!empty($data['dstime_id'])) {

            $Machines->dstime_id = $data['dstime_id'];

        }


        if (!empty($data['door_count'])) {

            $Machines->door_count = $data['door_count'];

        }


        if (!empty($data['reader_count'])) {

            $Machines->reader_count = $data['reader_count'];

        }


        if (!empty($data['aux_in_count'])) {

            $Machines->aux_in_count = $data['aux_in_count'];

        }


        if (!empty($data['aux_out_count'])) {

            $Machines->aux_out_count = $data['aux_out_count'];

        }


        if (!empty($data['IsOnlyRFMachine'])) {

            $Machines->IsOnlyRFMachine = $data['IsOnlyRFMachine'];

        }


        if (!empty($data['alias'])) {

            $Machines->alias = $data['alias'];

        }


        if (!empty($data['ipaddress'])) {

            $Machines->ipaddress = $data['ipaddress'];

        }


        if (!empty($data['com_port'])) {

            $Machines->com_port = $data['com_port'];

        }


        if (!empty($data['com_address'])) {

            $Machines->com_address = $data['com_address'];

        }


        if (!empty($data['DeviceNetmask'])) {

            $Machines->DeviceNetmask = $data['DeviceNetmask'];

        }


        if (!empty($data['DeviceGetway'])) {

            $Machines->DeviceGetway = $data['DeviceGetway'];

        }


        if (!empty($data['SimpleEventType'])) {

            $Machines->SimpleEventType = $data['SimpleEventType'];

        }


        if (!empty($data['FvFunOn'])) {

            $Machines->FvFunOn = $data['FvFunOn'];

        }


        if (!empty($data['fvcount'])) {

            $Machines->fvcount = $data['fvcount'];

        }


        if (!empty($data['deviceOption'])) {

            $Machines->deviceOption = $data['deviceOption'];

        }


        if (!empty($data['DevSDKType'])) {

            $Machines->DevSDKType = $data['DevSDKType'];

        }


        if (!empty($data['UTableDesc'])) {

            $Machines->UTableDesc = $data['UTableDesc'];

        }


        if (!empty($data['IsTFTMachine'])) {

            $Machines->IsTFTMachine = $data['IsTFTMachine'];

        }


        if (!empty($data['PinWidth'])) {

            $Machines->PinWidth = $data['PinWidth'];

        }


        if (!empty($data['UserExtFmt'])) {

            $Machines->UserExtFmt = $data['UserExtFmt'];

        }


        if (!empty($data['FP1_NThreshold'])) {

            $Machines->FP1_NThreshold = $data['FP1_NThreshold'];

        }


        if (!empty($data['FP1_1Threshold'])) {

            $Machines->FP1_1Threshold = $data['FP1_1Threshold'];

        }


        if (!empty($data['Face1_NThreshold'])) {

            $Machines->Face1_NThreshold = $data['Face1_NThreshold'];

        }


        if (!empty($data['Face1_1Threshold'])) {

            $Machines->Face1_1Threshold = $data['Face1_1Threshold'];

        }


        if (!empty($data['Only1_1Mode'])) {

            $Machines->Only1_1Mode = $data['Only1_1Mode'];

        }


        if (!empty($data['OnlyCheckCard'])) {

            $Machines->OnlyCheckCard = $data['OnlyCheckCard'];

        }


        if (!empty($data['MifireMustRegistered'])) {

            $Machines->MifireMustRegistered = $data['MifireMustRegistered'];

        }


        if (!empty($data['RFCardOn'])) {

            $Machines->RFCardOn = $data['RFCardOn'];

        }


        if (!empty($data['Mifire'])) {

            $Machines->Mifire = $data['Mifire'];

        }


        if (!empty($data['MifireId'])) {

            $Machines->MifireId = $data['MifireId'];

        }


        if (!empty($data['NetOn'])) {

            $Machines->NetOn = $data['NetOn'];

        }


        if (!empty($data['RS232On'])) {

            $Machines->RS232On = $data['RS232On'];

        }


        if (!empty($data['RS485On'])) {

            $Machines->RS485On = $data['RS485On'];

        }


        if (!empty($data['FreeType'])) {

            $Machines->FreeType = $data['FreeType'];

        }


        if (!empty($data['FreeTime'])) {

            $Machines->FreeTime = $data['FreeTime'];

        }


        if (!empty($data['NoDisplayFun'])) {

            $Machines->NoDisplayFun = $data['NoDisplayFun'];

        }


        if (!empty($data['VoiceTipsOn'])) {

            $Machines->VoiceTipsOn = $data['VoiceTipsOn'];

        }


        if (!empty($data['TOMenu'])) {

            $Machines->TOMenu = $data['TOMenu'];

        }


        if (!empty($data['StdVolume'])) {

            $Machines->StdVolume = $data['StdVolume'];

        }


        if (!empty($data['VRYVH'])) {

            $Machines->VRYVH = $data['VRYVH'];

        }


        if (!empty($data['KeyPadBeep'])) {

            $Machines->KeyPadBeep = $data['KeyPadBeep'];

        }


        if (!empty($data['BatchUpdate'])) {

            $Machines->BatchUpdate = $data['BatchUpdate'];

        }


        if (!empty($data['CardFun'])) {

            $Machines->CardFun = $data['CardFun'];

        }


        if (!empty($data['FaceFunOn'])) {

            $Machines->FaceFunOn = $data['FaceFunOn'];

        }


        if (!empty($data['FaceCount'])) {

            $Machines->FaceCount = $data['FaceCount'];

        }


        if (!empty($data['TimeAPBFunOn'])) {

            $Machines->TimeAPBFunOn = $data['TimeAPBFunOn'];

        }


        if (!empty($data['FingerFunOn'])) {

            $Machines->FingerFunOn = $data['FingerFunOn'];

        }


        if (!empty($data['CompatOldFirmware'])) {

            $Machines->CompatOldFirmware = $data['CompatOldFirmware'];

        }


        if (!empty($data['ParamValues'])) {

            $Machines->ParamValues = $data['ParamValues'];

        }


        if (!empty($data['WirelessSSID'])) {

            $Machines->WirelessSSID = $data['WirelessSSID'];

        }


        if (!empty($data['WirelessKey'])) {

            $Machines->WirelessKey = $data['WirelessKey'];

        }


        if (!empty($data['WirelessAddr'])) {

            $Machines->WirelessAddr = $data['WirelessAddr'];

        }


        if (!empty($data['WirelessMask'])) {

            $Machines->WirelessMask = $data['WirelessMask'];

        }


        if (!empty($data['WirelessGateWay'])) {

            $Machines->WirelessGateWay = $data['WirelessGateWay'];

        }


        if (!empty($data['IsWireless'])) {

            $Machines->IsWireless = $data['IsWireless'];

        }


        if (!empty($data['ACFun'])) {

            $Machines->ACFun = $data['ACFun'];

        }


        if (!empty($data['BiometricType'])) {

            $Machines->BiometricType = $data['BiometricType'];

        }


        if (!empty($data['BiometricVersion'])) {

            $Machines->BiometricVersion = $data['BiometricVersion'];

        }


        if (!empty($data['BiometricMaxCount'])) {

            $Machines->BiometricMaxCount = $data['BiometricMaxCount'];

        }


        if (!empty($data['BiometricUsedCount'])) {

            $Machines->BiometricUsedCount = $data['BiometricUsedCount'];

        }


        if (!empty($data['WIFI'])) {

            $Machines->WIFI = $data['WIFI'];

        }


        if (!empty($data['WIFIOn'])) {

            $Machines->WIFIOn = $data['WIFIOn'];

        }


        if (!empty($data['WIFIDHCP'])) {

            $Machines->WIFIDHCP = $data['WIFIDHCP'];

        }


        if (!empty($data['IsExtend'])) {

            $Machines->IsExtend = $data['IsExtend'];

        }


        if (!empty($data['identifiants_sadge'])) {

            $Machines->identifiants_sadge = $data['identifiants_sadge'];

        }


        if (!empty($data['creat_by'])) {

            $Machines->creat_by = $data['creat_by'];

        }


        $dat = [];

        foreach ($extra_data as $d) {

            $dat[$d] = $data[$d];

        }
        try {

            $Machines->extra_attributes["extra-data"] = $dat;


        } catch (Throwable $e) {
        }

        if (
            class_exists('\App\Http\Extras\MachineExtras') &&
            method_exists('\App\Http\Extras\MachineExtras', 'beforeSaveCreate')
        ) {
            MachineExtras::beforeSaveCreate($request, $Machines);
        }

        $canSave = true;
        if (
            class_exists('\App\Http\Extras\MachineExtras') &&
            method_exists('\App\Http\Extras\MachineExtras', 'canCreate')
        ) {
            try {
                $canSave = MachineExtras::canCreate($request, $Machines);
            } catch (Throwable $e) {

            }

        }


        if ($canSave) {
            $Machines->save();
        } else {
            return response()->json($Machines, 200);
        }

        $Machines = Machine::find($Machines->id);
        $newCrudData = [];

        $newCrudData['ID'] = $Machines->ID;
        $newCrudData['MachineAlias'] = $Machines->MachineAlias;
        $newCrudData['ConnectType'] = $Machines->ConnectType;
        $newCrudData['IP'] = $Machines->IP;
        $newCrudData['SerialPort'] = $Machines->SerialPort;
        $newCrudData['Port'] = $Machines->Port;
        $newCrudData['Baudrate'] = $Machines->Baudrate;
        $newCrudData['MachineNumber'] = $Machines->MachineNumber;
        $newCrudData['IsHost'] = $Machines->IsHost;
        $newCrudData['Enabled'] = $Machines->Enabled;
        $newCrudData['CommPassword'] = $Machines->CommPassword;
        $newCrudData['UILanguage'] = $Machines->UILanguage;
        $newCrudData['DateFormat'] = $Machines->DateFormat;
        $newCrudData['InOutRecordWarn'] = $Machines->InOutRecordWarn;
        $newCrudData['Idle'] = $Machines->Idle;
        $newCrudData['Voice'] = $Machines->Voice;
        $newCrudData['managercount'] = $Machines->managercount;
        $newCrudData['usercount'] = $Machines->usercount;
        $newCrudData['fingercount'] = $Machines->fingercount;
        $newCrudData['SecretCount'] = $Machines->SecretCount;
        $newCrudData['FirmwareVersion'] = $Machines->FirmwareVersion;
        $newCrudData['ProductType'] = $Machines->ProductType;
        $newCrudData['LockControl'] = $Machines->LockControl;
        $newCrudData['Purpose'] = $Machines->Purpose;
        $newCrudData['ProduceKind'] = $Machines->ProduceKind;
        $newCrudData['sn'] = $Machines->sn;
        $newCrudData['PhotoStamp'] = $Machines->PhotoStamp;
        $newCrudData['IsIfChangeConfigServer2'] = $Machines->IsIfChangeConfigServer2;
        $newCrudData['pushver'] = $Machines->pushver;
        $newCrudData['change_operator'] = $Machines->change_operator;
        $newCrudData['change_time'] = $Machines->change_time;
        $newCrudData['create_operator'] = $Machines->create_operator;
        $newCrudData['create_time'] = $Machines->create_time;
        $newCrudData['delete_operator'] = $Machines->delete_operator;
        $newCrudData['delete_time'] = $Machines->delete_time;
        $newCrudData['status'] = $Machines->status;
        $newCrudData['device_type'] = $Machines->device_type;
        $newCrudData['last_activity'] = $Machines->last_activity;
        $newCrudData['trans_times'] = $Machines->trans_times;
        $newCrudData['TransInterval'] = $Machines->TransInterval;
        $newCrudData['log_stamp'] = $Machines->log_stamp;
        $newCrudData['oplog_stamp'] = $Machines->oplog_stamp;
        $newCrudData['photo_stamp'] = $Machines->photo_stamp;
        $newCrudData['UpdateDB'] = $Machines->UpdateDB;
        $newCrudData['device_name'] = $Machines->device_name;
        $newCrudData['transaction_count'] = $Machines->transaction_count;
        $newCrudData['main_time'] = $Machines->main_time;
        $newCrudData['max_user_count'] = $Machines->max_user_count;
        $newCrudData['max_finger_count'] = $Machines->max_finger_count;
        $newCrudData['max_attlog_count'] = $Machines->max_attlog_count;
        $newCrudData['alg_ver'] = $Machines->alg_ver;
        $newCrudData['flash_size'] = $Machines->flash_size;
        $newCrudData['free_flash_size'] = $Machines->free_flash_size;
        $newCrudData['language'] = $Machines->language;
        $newCrudData['lng_encode'] = $Machines->lng_encode;
        $newCrudData['volume'] = $Machines->volume;
        $newCrudData['is_tft'] = $Machines->is_tft;
        $newCrudData['platform'] = $Machines->platform;
        $newCrudData['brightness'] = $Machines->brightness;
        $newCrudData['oem_vendor'] = $Machines->oem_vendor;
        $newCrudData['city'] = $Machines->city;
        $newCrudData['AccFun'] = $Machines->AccFun;
        $newCrudData['TZAdj'] = $Machines->TZAdj;
        $newCrudData['comm_type'] = $Machines->comm_type;
        $newCrudData['agent_ipaddress'] = $Machines->agent_ipaddress;
        $newCrudData['subnet_mask'] = $Machines->subnet_mask;
        $newCrudData['gateway'] = $Machines->gateway;
        $newCrudData['area_id'] = $Machines->area_id;
        $newCrudData['acpanel_type'] = $Machines->acpanel_type;
        $newCrudData['sync_time'] = $Machines->sync_time;
        $newCrudData['four_to_two'] = $Machines->four_to_two;
        $newCrudData['video_login'] = $Machines->video_login;
        $newCrudData['fp_mthreshold'] = $Machines->fp_mthreshold;
        $newCrudData['Fpversion'] = $Machines->Fpversion;
        $newCrudData['max_comm_size'] = $Machines->max_comm_size;
        $newCrudData['max_comm_count'] = $Machines->max_comm_count;
        $newCrudData['realtime'] = $Machines->realtime;
        $newCrudData['delay'] = $Machines->delay;
        $newCrudData['encrypt'] = $Machines->encrypt;
        $newCrudData['dstime_id'] = $Machines->dstime_id;
        $newCrudData['door_count'] = $Machines->door_count;
        $newCrudData['reader_count'] = $Machines->reader_count;
        $newCrudData['aux_in_count'] = $Machines->aux_in_count;
        $newCrudData['aux_out_count'] = $Machines->aux_out_count;
        $newCrudData['IsOnlyRFMachine'] = $Machines->IsOnlyRFMachine;
        $newCrudData['alias'] = $Machines->alias;
        $newCrudData['ipaddress'] = $Machines->ipaddress;
        $newCrudData['com_port'] = $Machines->com_port;
        $newCrudData['com_address'] = $Machines->com_address;
        $newCrudData['DeviceNetmask'] = $Machines->DeviceNetmask;
        $newCrudData['DeviceGetway'] = $Machines->DeviceGetway;
        $newCrudData['SimpleEventType'] = $Machines->SimpleEventType;
        $newCrudData['FvFunOn'] = $Machines->FvFunOn;
        $newCrudData['fvcount'] = $Machines->fvcount;
        $newCrudData['deviceOption'] = $Machines->deviceOption;
        $newCrudData['DevSDKType'] = $Machines->DevSDKType;
        $newCrudData['UTableDesc'] = $Machines->UTableDesc;
        $newCrudData['IsTFTMachine'] = $Machines->IsTFTMachine;
        $newCrudData['PinWidth'] = $Machines->PinWidth;
        $newCrudData['UserExtFmt'] = $Machines->UserExtFmt;
        $newCrudData['FP1_NThreshold'] = $Machines->FP1_NThreshold;
        $newCrudData['FP1_1Threshold'] = $Machines->FP1_1Threshold;
        $newCrudData['Face1_NThreshold'] = $Machines->Face1_NThreshold;
        $newCrudData['Face1_1Threshold'] = $Machines->Face1_1Threshold;
        $newCrudData['Only1_1Mode'] = $Machines->Only1_1Mode;
        $newCrudData['OnlyCheckCard'] = $Machines->OnlyCheckCard;
        $newCrudData['MifireMustRegistered'] = $Machines->MifireMustRegistered;
        $newCrudData['RFCardOn'] = $Machines->RFCardOn;
        $newCrudData['Mifire'] = $Machines->Mifire;
        $newCrudData['MifireId'] = $Machines->MifireId;
        $newCrudData['NetOn'] = $Machines->NetOn;
        $newCrudData['RS232On'] = $Machines->RS232On;
        $newCrudData['RS485On'] = $Machines->RS485On;
        $newCrudData['FreeType'] = $Machines->FreeType;
        $newCrudData['FreeTime'] = $Machines->FreeTime;
        $newCrudData['NoDisplayFun'] = $Machines->NoDisplayFun;
        $newCrudData['VoiceTipsOn'] = $Machines->VoiceTipsOn;
        $newCrudData['TOMenu'] = $Machines->TOMenu;
        $newCrudData['StdVolume'] = $Machines->StdVolume;
        $newCrudData['VRYVH'] = $Machines->VRYVH;
        $newCrudData['KeyPadBeep'] = $Machines->KeyPadBeep;
        $newCrudData['BatchUpdate'] = $Machines->BatchUpdate;
        $newCrudData['CardFun'] = $Machines->CardFun;
        $newCrudData['FaceFunOn'] = $Machines->FaceFunOn;
        $newCrudData['FaceCount'] = $Machines->FaceCount;
        $newCrudData['TimeAPBFunOn'] = $Machines->TimeAPBFunOn;
        $newCrudData['FingerFunOn'] = $Machines->FingerFunOn;
        $newCrudData['CompatOldFirmware'] = $Machines->CompatOldFirmware;
        $newCrudData['ParamValues'] = $Machines->ParamValues;
        $newCrudData['WirelessSSID'] = $Machines->WirelessSSID;
        $newCrudData['WirelessKey'] = $Machines->WirelessKey;
        $newCrudData['WirelessAddr'] = $Machines->WirelessAddr;
        $newCrudData['WirelessMask'] = $Machines->WirelessMask;
        $newCrudData['WirelessGateWay'] = $Machines->WirelessGateWay;
        $newCrudData['IsWireless'] = $Machines->IsWireless;
        $newCrudData['ACFun'] = $Machines->ACFun;
        $newCrudData['BiometricType'] = $Machines->BiometricType;
        $newCrudData['BiometricVersion'] = $Machines->BiometricVersion;
        $newCrudData['BiometricMaxCount'] = $Machines->BiometricMaxCount;
        $newCrudData['BiometricUsedCount'] = $Machines->BiometricUsedCount;
        $newCrudData['WIFI'] = $Machines->WIFI;
        $newCrudData['WIFIOn'] = $Machines->WIFIOn;
        $newCrudData['WIFIDHCP'] = $Machines->WIFIDHCP;
        $newCrudData['IsExtend'] = $Machines->IsExtend;
        $newCrudData['identifiants_sadge'] = $Machines->identifiants_sadge;
        $newCrudData['creat_by'] = $Machines->creat_by;


        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Machines', 'entite_cle' => $Machines->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);


        $response = $Machines->toArray();


        try {

            foreach ($Machines->extra_attributes["extra-data"] as $key => $dat) {
                $response[$key] = $dat;
            }


        } catch (Throwable $e) {
        }


        return response()->json($response, 200);


    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */


    public function update(Request $request, Machine $Machines)
    {
        try {
            $can = Helpers::can('Editer des Machines');

            if (!$can) {
                return response()->json([], 200);
            }
        } catch (Throwable $e) {
        }

        $oldCrudData = [];

        $oldCrudData['ID'] = $Machines->ID;
        $oldCrudData['MachineAlias'] = $Machines->MachineAlias;
        $oldCrudData['ConnectType'] = $Machines->ConnectType;
        $oldCrudData['IP'] = $Machines->IP;
        $oldCrudData['SerialPort'] = $Machines->SerialPort;
        $oldCrudData['Port'] = $Machines->Port;
        $oldCrudData['Baudrate'] = $Machines->Baudrate;
        $oldCrudData['MachineNumber'] = $Machines->MachineNumber;
        $oldCrudData['IsHost'] = $Machines->IsHost;
        $oldCrudData['Enabled'] = $Machines->Enabled;
        $oldCrudData['CommPassword'] = $Machines->CommPassword;
        $oldCrudData['UILanguage'] = $Machines->UILanguage;
        $oldCrudData['DateFormat'] = $Machines->DateFormat;
        $oldCrudData['InOutRecordWarn'] = $Machines->InOutRecordWarn;
        $oldCrudData['Idle'] = $Machines->Idle;
        $oldCrudData['Voice'] = $Machines->Voice;
        $oldCrudData['managercount'] = $Machines->managercount;
        $oldCrudData['usercount'] = $Machines->usercount;
        $oldCrudData['fingercount'] = $Machines->fingercount;
        $oldCrudData['SecretCount'] = $Machines->SecretCount;
        $oldCrudData['FirmwareVersion'] = $Machines->FirmwareVersion;
        $oldCrudData['ProductType'] = $Machines->ProductType;
        $oldCrudData['LockControl'] = $Machines->LockControl;
        $oldCrudData['Purpose'] = $Machines->Purpose;
        $oldCrudData['ProduceKind'] = $Machines->ProduceKind;
        $oldCrudData['sn'] = $Machines->sn;
        $oldCrudData['PhotoStamp'] = $Machines->PhotoStamp;
        $oldCrudData['IsIfChangeConfigServer2'] = $Machines->IsIfChangeConfigServer2;
        $oldCrudData['pushver'] = $Machines->pushver;
        $oldCrudData['change_operator'] = $Machines->change_operator;
        $oldCrudData['change_time'] = $Machines->change_time;
        $oldCrudData['create_operator'] = $Machines->create_operator;
        $oldCrudData['create_time'] = $Machines->create_time;
        $oldCrudData['delete_operator'] = $Machines->delete_operator;
        $oldCrudData['delete_time'] = $Machines->delete_time;
        $oldCrudData['status'] = $Machines->status;
        $oldCrudData['device_type'] = $Machines->device_type;
        $oldCrudData['last_activity'] = $Machines->last_activity;
        $oldCrudData['trans_times'] = $Machines->trans_times;
        $oldCrudData['TransInterval'] = $Machines->TransInterval;
        $oldCrudData['log_stamp'] = $Machines->log_stamp;
        $oldCrudData['oplog_stamp'] = $Machines->oplog_stamp;
        $oldCrudData['photo_stamp'] = $Machines->photo_stamp;
        $oldCrudData['UpdateDB'] = $Machines->UpdateDB;
        $oldCrudData['device_name'] = $Machines->device_name;
        $oldCrudData['transaction_count'] = $Machines->transaction_count;
        $oldCrudData['main_time'] = $Machines->main_time;
        $oldCrudData['max_user_count'] = $Machines->max_user_count;
        $oldCrudData['max_finger_count'] = $Machines->max_finger_count;
        $oldCrudData['max_attlog_count'] = $Machines->max_attlog_count;
        $oldCrudData['alg_ver'] = $Machines->alg_ver;
        $oldCrudData['flash_size'] = $Machines->flash_size;
        $oldCrudData['free_flash_size'] = $Machines->free_flash_size;
        $oldCrudData['language'] = $Machines->language;
        $oldCrudData['lng_encode'] = $Machines->lng_encode;
        $oldCrudData['volume'] = $Machines->volume;
        $oldCrudData['is_tft'] = $Machines->is_tft;
        $oldCrudData['platform'] = $Machines->platform;
        $oldCrudData['brightness'] = $Machines->brightness;
        $oldCrudData['oem_vendor'] = $Machines->oem_vendor;
        $oldCrudData['city'] = $Machines->city;
        $oldCrudData['AccFun'] = $Machines->AccFun;
        $oldCrudData['TZAdj'] = $Machines->TZAdj;
        $oldCrudData['comm_type'] = $Machines->comm_type;
        $oldCrudData['agent_ipaddress'] = $Machines->agent_ipaddress;
        $oldCrudData['subnet_mask'] = $Machines->subnet_mask;
        $oldCrudData['gateway'] = $Machines->gateway;
        $oldCrudData['area_id'] = $Machines->area_id;
        $oldCrudData['acpanel_type'] = $Machines->acpanel_type;
        $oldCrudData['sync_time'] = $Machines->sync_time;
        $oldCrudData['four_to_two'] = $Machines->four_to_two;
        $oldCrudData['video_login'] = $Machines->video_login;
        $oldCrudData['fp_mthreshold'] = $Machines->fp_mthreshold;
        $oldCrudData['Fpversion'] = $Machines->Fpversion;
        $oldCrudData['max_comm_size'] = $Machines->max_comm_size;
        $oldCrudData['max_comm_count'] = $Machines->max_comm_count;
        $oldCrudData['realtime'] = $Machines->realtime;
        $oldCrudData['delay'] = $Machines->delay;
        $oldCrudData['encrypt'] = $Machines->encrypt;
        $oldCrudData['dstime_id'] = $Machines->dstime_id;
        $oldCrudData['door_count'] = $Machines->door_count;
        $oldCrudData['reader_count'] = $Machines->reader_count;
        $oldCrudData['aux_in_count'] = $Machines->aux_in_count;
        $oldCrudData['aux_out_count'] = $Machines->aux_out_count;
        $oldCrudData['IsOnlyRFMachine'] = $Machines->IsOnlyRFMachine;
        $oldCrudData['alias'] = $Machines->alias;
        $oldCrudData['ipaddress'] = $Machines->ipaddress;
        $oldCrudData['com_port'] = $Machines->com_port;
        $oldCrudData['com_address'] = $Machines->com_address;
        $oldCrudData['DeviceNetmask'] = $Machines->DeviceNetmask;
        $oldCrudData['DeviceGetway'] = $Machines->DeviceGetway;
        $oldCrudData['SimpleEventType'] = $Machines->SimpleEventType;
        $oldCrudData['FvFunOn'] = $Machines->FvFunOn;
        $oldCrudData['fvcount'] = $Machines->fvcount;
        $oldCrudData['deviceOption'] = $Machines->deviceOption;
        $oldCrudData['DevSDKType'] = $Machines->DevSDKType;
        $oldCrudData['UTableDesc'] = $Machines->UTableDesc;
        $oldCrudData['IsTFTMachine'] = $Machines->IsTFTMachine;
        $oldCrudData['PinWidth'] = $Machines->PinWidth;
        $oldCrudData['UserExtFmt'] = $Machines->UserExtFmt;
        $oldCrudData['FP1_NThreshold'] = $Machines->FP1_NThreshold;
        $oldCrudData['FP1_1Threshold'] = $Machines->FP1_1Threshold;
        $oldCrudData['Face1_NThreshold'] = $Machines->Face1_NThreshold;
        $oldCrudData['Face1_1Threshold'] = $Machines->Face1_1Threshold;
        $oldCrudData['Only1_1Mode'] = $Machines->Only1_1Mode;
        $oldCrudData['OnlyCheckCard'] = $Machines->OnlyCheckCard;
        $oldCrudData['MifireMustRegistered'] = $Machines->MifireMustRegistered;
        $oldCrudData['RFCardOn'] = $Machines->RFCardOn;
        $oldCrudData['Mifire'] = $Machines->Mifire;
        $oldCrudData['MifireId'] = $Machines->MifireId;
        $oldCrudData['NetOn'] = $Machines->NetOn;
        $oldCrudData['RS232On'] = $Machines->RS232On;
        $oldCrudData['RS485On'] = $Machines->RS485On;
        $oldCrudData['FreeType'] = $Machines->FreeType;
        $oldCrudData['FreeTime'] = $Machines->FreeTime;
        $oldCrudData['NoDisplayFun'] = $Machines->NoDisplayFun;
        $oldCrudData['VoiceTipsOn'] = $Machines->VoiceTipsOn;
        $oldCrudData['TOMenu'] = $Machines->TOMenu;
        $oldCrudData['StdVolume'] = $Machines->StdVolume;
        $oldCrudData['VRYVH'] = $Machines->VRYVH;
        $oldCrudData['KeyPadBeep'] = $Machines->KeyPadBeep;
        $oldCrudData['BatchUpdate'] = $Machines->BatchUpdate;
        $oldCrudData['CardFun'] = $Machines->CardFun;
        $oldCrudData['FaceFunOn'] = $Machines->FaceFunOn;
        $oldCrudData['FaceCount'] = $Machines->FaceCount;
        $oldCrudData['TimeAPBFunOn'] = $Machines->TimeAPBFunOn;
        $oldCrudData['FingerFunOn'] = $Machines->FingerFunOn;
        $oldCrudData['CompatOldFirmware'] = $Machines->CompatOldFirmware;
        $oldCrudData['ParamValues'] = $Machines->ParamValues;
        $oldCrudData['WirelessSSID'] = $Machines->WirelessSSID;
        $oldCrudData['WirelessKey'] = $Machines->WirelessKey;
        $oldCrudData['WirelessAddr'] = $Machines->WirelessAddr;
        $oldCrudData['WirelessMask'] = $Machines->WirelessMask;
        $oldCrudData['WirelessGateWay'] = $Machines->WirelessGateWay;
        $oldCrudData['IsWireless'] = $Machines->IsWireless;
        $oldCrudData['ACFun'] = $Machines->ACFun;
        $oldCrudData['BiometricType'] = $Machines->BiometricType;
        $oldCrudData['BiometricVersion'] = $Machines->BiometricVersion;
        $oldCrudData['BiometricMaxCount'] = $Machines->BiometricMaxCount;
        $oldCrudData['BiometricUsedCount'] = $Machines->BiometricUsedCount;
        $oldCrudData['WIFI'] = $Machines->WIFI;
        $oldCrudData['WIFIOn'] = $Machines->WIFIOn;
        $oldCrudData['WIFIDHCP'] = $Machines->WIFIDHCP;
        $oldCrudData['IsExtend'] = $Machines->IsExtend;
        $oldCrudData['identifiants_sadge'] = $Machines->identifiants_sadge;
        $oldCrudData['creat_by'] = $Machines->creat_by;


        $data = $request->all();
        foreach ($request->allFiles() as $key => $file) {
            $path = $file->storeAs(
                'storage/uploads', "Machines" . "-" . $key . "_" . time() . "." . $file->extension()
            );
            $data[$key] = $path;
        }


        $champsRechercher = [
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
        $envoyer = [];
        foreach ($data as $key => $d) {
            $envoyer[] = $key;


        }
        $envoyer = array_unique($envoyer);

        Validator::make($data, [

            'ID' => [
                //'required'
            ],


            'MachineAlias' => [
                //'required'
            ],


            'ConnectType' => [
                //'required'
            ],


            'IP' => [
                //'required'
            ],


            'SerialPort' => [
                //'required'
            ],


            'Port' => [
                //'required'
            ],


            'Baudrate' => [
                //'required'
            ],


            'MachineNumber' => [
                //'required'
            ],


            'IsHost' => [
                //'required'
            ],


            'Enabled' => [
                //'required'
            ],


            'CommPassword' => [
                //'required'
            ],


            'UILanguage' => [
                //'required'
            ],


            'DateFormat' => [
                //'required'
            ],


            'InOutRecordWarn' => [
                //'required'
            ],


            'Idle' => [
                //'required'
            ],


            'Voice' => [
                //'required'
            ],


            'managercount' => [
                //'required'
            ],


            'usercount' => [
                //'required'
            ],


            'fingercount' => [
                //'required'
            ],


            'SecretCount' => [
                //'required'
            ],


            'FirmwareVersion' => [
                //'required'
            ],


            'ProductType' => [
                //'required'
            ],


            'LockControl' => [
                //'required'
            ],


            'Purpose' => [
                //'required'
            ],


            'ProduceKind' => [
                //'required'
            ],


            'sn' => [
                //'required'
            ],


            'PhotoStamp' => [
                //'required'
            ],


            'IsIfChangeConfigServer2' => [
                //'required'
            ],


            'pushver' => [
                //'required'
            ],


            'change_operator' => [
                //'required'
            ],


            'change_time' => [
                //'required'
            ],


            'create_operator' => [
                //'required'
            ],


            'create_time' => [
                //'required'
            ],


            'delete_operator' => [
                //'required'
            ],


            'delete_time' => [
                //'required'
            ],


            'status' => [
                //'required'
            ],


            'device_type' => [
                //'required'
            ],


            'last_activity' => [
                //'required'
            ],


            'trans_times' => [
                //'required'
            ],


            'TransInterval' => [
                //'required'
            ],


            'log_stamp' => [
                //'required'
            ],


            'oplog_stamp' => [
                //'required'
            ],


            'photo_stamp' => [
                //'required'
            ],


            'UpdateDB' => [
                //'required'
            ],


            'device_name' => [
                //'required'
            ],


            'transaction_count' => [
                //'required'
            ],


            'main_time' => [
                //'required'
            ],


            'max_user_count' => [
                //'required'
            ],


            'max_finger_count' => [
                //'required'
            ],


            'max_attlog_count' => [
                //'required'
            ],


            'alg_ver' => [
                //'required'
            ],


            'flash_size' => [
                //'required'
            ],


            'free_flash_size' => [
                //'required'
            ],


            'language' => [
                //'required'
            ],


            'lng_encode' => [
                //'required'
            ],


            'volume' => [
                //'required'
            ],


            'is_tft' => [
                //'required'
            ],


            'platform' => [
                //'required'
            ],


            'brightness' => [
                //'required'
            ],


            'oem_vendor' => [
                //'required'
            ],


            'city' => [
                //'required'
            ],


            'AccFun' => [
                //'required'
            ],


            'TZAdj' => [
                //'required'
            ],


            'comm_type' => [
                //'required'
            ],


            'agent_ipaddress' => [
                //'required'
            ],


            'subnet_mask' => [
                //'required'
            ],


            'gateway' => [
                //'required'
            ],


            'area_id' => [
                //'required'
            ],


            'acpanel_type' => [
                //'required'
            ],


            'sync_time' => [
                //'required'
            ],


            'four_to_two' => [
                //'required'
            ],


            'video_login' => [
                //'required'
            ],


            'fp_mthreshold' => [
                //'required'
            ],


            'Fpversion' => [
                //'required'
            ],


            'max_comm_size' => [
                //'required'
            ],


            'max_comm_count' => [
                //'required'
            ],


            'realtime' => [
                //'required'
            ],


            'delay' => [
                //'required'
            ],


            'encrypt' => [
                //'required'
            ],


            'dstime_id' => [
                //'required'
            ],


            'door_count' => [
                //'required'
            ],


            'reader_count' => [
                //'required'
            ],


            'aux_in_count' => [
                //'required'
            ],


            'aux_out_count' => [
                //'required'
            ],


            'IsOnlyRFMachine' => [
                //'required'
            ],


            'alias' => [
                //'required'
            ],


            'ipaddress' => [
                //'required'
            ],


            'com_port' => [
                //'required'
            ],


            'com_address' => [
                //'required'
            ],


            'DeviceNetmask' => [
                //'required'
            ],


            'DeviceGetway' => [
                //'required'
            ],


            'SimpleEventType' => [
                //'required'
            ],


            'FvFunOn' => [
                //'required'
            ],


            'fvcount' => [
                //'required'
            ],


            'deviceOption' => [
                //'required'
            ],


            'DevSDKType' => [
                //'required'
            ],


            'UTableDesc' => [
                //'required'
            ],


            'IsTFTMachine' => [
                //'required'
            ],


            'PinWidth' => [
                //'required'
            ],


            'UserExtFmt' => [
                //'required'
            ],


            'FP1_NThreshold' => [
                //'required'
            ],


            'FP1_1Threshold' => [
                //'required'
            ],


            'Face1_NThreshold' => [
                //'required'
            ],


            'Face1_1Threshold' => [
                //'required'
            ],


            'Only1_1Mode' => [
                //'required'
            ],


            'OnlyCheckCard' => [
                //'required'
            ],


            'MifireMustRegistered' => [
                //'required'
            ],


            'RFCardOn' => [
                //'required'
            ],


            'Mifire' => [
                //'required'
            ],


            'MifireId' => [
                //'required'
            ],


            'NetOn' => [
                //'required'
            ],


            'RS232On' => [
                //'required'
            ],


            'RS485On' => [
                //'required'
            ],


            'FreeType' => [
                //'required'
            ],


            'FreeTime' => [
                //'required'
            ],


            'NoDisplayFun' => [
                //'required'
            ],


            'VoiceTipsOn' => [
                //'required'
            ],


            'TOMenu' => [
                //'required'
            ],


            'StdVolume' => [
                //'required'
            ],


            'VRYVH' => [
                //'required'
            ],


            'KeyPadBeep' => [
                //'required'
            ],


            'BatchUpdate' => [
                //'required'
            ],


            'CardFun' => [
                //'required'
            ],


            'FaceFunOn' => [
                //'required'
            ],


            'FaceCount' => [
                //'required'
            ],


            'TimeAPBFunOn' => [
                //'required'
            ],


            'FingerFunOn' => [
                //'required'
            ],


            'CompatOldFirmware' => [
                //'required'
            ],


            'ParamValues' => [
                //'required'
            ],


            'WirelessSSID' => [
                //'required'
            ],


            'WirelessKey' => [
                //'required'
            ],


            'WirelessAddr' => [
                //'required'
            ],


            'WirelessMask' => [
                //'required'
            ],


            'WirelessGateWay' => [
                //'required'
            ],


            'IsWireless' => [
                //'required'
            ],


            'ACFun' => [
                //'required'
            ],


            'BiometricType' => [
                //'required'
            ],


            'BiometricVersion' => [
                //'required'
            ],


            'BiometricMaxCount' => [
                //'required'
            ],


            'BiometricUsedCount' => [
                //'required'
            ],


            'WIFI' => [
                //'required'
            ],


            'WIFIOn' => [
                //'required'
            ],


            'WIFIDHCP' => [
                //'required'
            ],


            'IsExtend' => [
                //'required'
            ],


            'identifiants_sadge' => [
                //'required'
            ],


            'creat_by' => [
                //'required'
            ],


        ], $messages = [


            'ID' => ['cette donnee est obligatoire'],


            'MachineAlias' => ['cette donnee est obligatoire'],


            'ConnectType' => ['cette donnee est obligatoire'],


            'IP' => ['cette donnee est obligatoire'],


            'SerialPort' => ['cette donnee est obligatoire'],


            'Port' => ['cette donnee est obligatoire'],


            'Baudrate' => ['cette donnee est obligatoire'],


            'MachineNumber' => ['cette donnee est obligatoire'],


            'IsHost' => ['cette donnee est obligatoire'],


            'Enabled' => ['cette donnee est obligatoire'],


            'CommPassword' => ['cette donnee est obligatoire'],


            'UILanguage' => ['cette donnee est obligatoire'],


            'DateFormat' => ['cette donnee est obligatoire'],


            'InOutRecordWarn' => ['cette donnee est obligatoire'],


            'Idle' => ['cette donnee est obligatoire'],


            'Voice' => ['cette donnee est obligatoire'],


            'managercount' => ['cette donnee est obligatoire'],


            'usercount' => ['cette donnee est obligatoire'],


            'fingercount' => ['cette donnee est obligatoire'],


            'SecretCount' => ['cette donnee est obligatoire'],


            'FirmwareVersion' => ['cette donnee est obligatoire'],


            'ProductType' => ['cette donnee est obligatoire'],


            'LockControl' => ['cette donnee est obligatoire'],


            'Purpose' => ['cette donnee est obligatoire'],


            'ProduceKind' => ['cette donnee est obligatoire'],


            'sn' => ['cette donnee est obligatoire'],


            'PhotoStamp' => ['cette donnee est obligatoire'],


            'IsIfChangeConfigServer2' => ['cette donnee est obligatoire'],


            'pushver' => ['cette donnee est obligatoire'],


            'change_operator' => ['cette donnee est obligatoire'],


            'change_time' => ['cette donnee est obligatoire'],


            'create_operator' => ['cette donnee est obligatoire'],


            'create_time' => ['cette donnee est obligatoire'],


            'delete_operator' => ['cette donnee est obligatoire'],


            'delete_time' => ['cette donnee est obligatoire'],


            'status' => ['cette donnee est obligatoire'],


            'device_type' => ['cette donnee est obligatoire'],


            'last_activity' => ['cette donnee est obligatoire'],


            'trans_times' => ['cette donnee est obligatoire'],


            'TransInterval' => ['cette donnee est obligatoire'],


            'log_stamp' => ['cette donnee est obligatoire'],


            'oplog_stamp' => ['cette donnee est obligatoire'],


            'photo_stamp' => ['cette donnee est obligatoire'],


            'UpdateDB' => ['cette donnee est obligatoire'],


            'device_name' => ['cette donnee est obligatoire'],


            'transaction_count' => ['cette donnee est obligatoire'],


            'main_time' => ['cette donnee est obligatoire'],


            'max_user_count' => ['cette donnee est obligatoire'],


            'max_finger_count' => ['cette donnee est obligatoire'],


            'max_attlog_count' => ['cette donnee est obligatoire'],


            'alg_ver' => ['cette donnee est obligatoire'],


            'flash_size' => ['cette donnee est obligatoire'],


            'free_flash_size' => ['cette donnee est obligatoire'],


            'language' => ['cette donnee est obligatoire'],


            'lng_encode' => ['cette donnee est obligatoire'],


            'volume' => ['cette donnee est obligatoire'],


            'is_tft' => ['cette donnee est obligatoire'],


            'platform' => ['cette donnee est obligatoire'],


            'brightness' => ['cette donnee est obligatoire'],


            'oem_vendor' => ['cette donnee est obligatoire'],


            'city' => ['cette donnee est obligatoire'],


            'AccFun' => ['cette donnee est obligatoire'],


            'TZAdj' => ['cette donnee est obligatoire'],


            'comm_type' => ['cette donnee est obligatoire'],


            'agent_ipaddress' => ['cette donnee est obligatoire'],


            'subnet_mask' => ['cette donnee est obligatoire'],


            'gateway' => ['cette donnee est obligatoire'],


            'area_id' => ['cette donnee est obligatoire'],


            'acpanel_type' => ['cette donnee est obligatoire'],


            'sync_time' => ['cette donnee est obligatoire'],


            'four_to_two' => ['cette donnee est obligatoire'],


            'video_login' => ['cette donnee est obligatoire'],


            'fp_mthreshold' => ['cette donnee est obligatoire'],


            'Fpversion' => ['cette donnee est obligatoire'],


            'max_comm_size' => ['cette donnee est obligatoire'],


            'max_comm_count' => ['cette donnee est obligatoire'],


            'realtime' => ['cette donnee est obligatoire'],


            'delay' => ['cette donnee est obligatoire'],


            'encrypt' => ['cette donnee est obligatoire'],


            'dstime_id' => ['cette donnee est obligatoire'],


            'door_count' => ['cette donnee est obligatoire'],


            'reader_count' => ['cette donnee est obligatoire'],


            'aux_in_count' => ['cette donnee est obligatoire'],


            'aux_out_count' => ['cette donnee est obligatoire'],


            'IsOnlyRFMachine' => ['cette donnee est obligatoire'],


            'alias' => ['cette donnee est obligatoire'],


            'ipaddress' => ['cette donnee est obligatoire'],


            'com_port' => ['cette donnee est obligatoire'],


            'com_address' => ['cette donnee est obligatoire'],


            'DeviceNetmask' => ['cette donnee est obligatoire'],


            'DeviceGetway' => ['cette donnee est obligatoire'],


            'SimpleEventType' => ['cette donnee est obligatoire'],


            'FvFunOn' => ['cette donnee est obligatoire'],


            'fvcount' => ['cette donnee est obligatoire'],


            'deviceOption' => ['cette donnee est obligatoire'],


            'DevSDKType' => ['cette donnee est obligatoire'],


            'UTableDesc' => ['cette donnee est obligatoire'],


            'IsTFTMachine' => ['cette donnee est obligatoire'],


            'PinWidth' => ['cette donnee est obligatoire'],


            'UserExtFmt' => ['cette donnee est obligatoire'],


            'FP1_NThreshold' => ['cette donnee est obligatoire'],


            'FP1_1Threshold' => ['cette donnee est obligatoire'],


            'Face1_NThreshold' => ['cette donnee est obligatoire'],


            'Face1_1Threshold' => ['cette donnee est obligatoire'],


            'Only1_1Mode' => ['cette donnee est obligatoire'],


            'OnlyCheckCard' => ['cette donnee est obligatoire'],


            'MifireMustRegistered' => ['cette donnee est obligatoire'],


            'RFCardOn' => ['cette donnee est obligatoire'],


            'Mifire' => ['cette donnee est obligatoire'],


            'MifireId' => ['cette donnee est obligatoire'],


            'NetOn' => ['cette donnee est obligatoire'],


            'RS232On' => ['cette donnee est obligatoire'],


            'RS485On' => ['cette donnee est obligatoire'],


            'FreeType' => ['cette donnee est obligatoire'],


            'FreeTime' => ['cette donnee est obligatoire'],


            'NoDisplayFun' => ['cette donnee est obligatoire'],


            'VoiceTipsOn' => ['cette donnee est obligatoire'],


            'TOMenu' => ['cette donnee est obligatoire'],


            'StdVolume' => ['cette donnee est obligatoire'],


            'VRYVH' => ['cette donnee est obligatoire'],


            'KeyPadBeep' => ['cette donnee est obligatoire'],


            'BatchUpdate' => ['cette donnee est obligatoire'],


            'CardFun' => ['cette donnee est obligatoire'],


            'FaceFunOn' => ['cette donnee est obligatoire'],


            'FaceCount' => ['cette donnee est obligatoire'],


            'TimeAPBFunOn' => ['cette donnee est obligatoire'],


            'FingerFunOn' => ['cette donnee est obligatoire'],


            'CompatOldFirmware' => ['cette donnee est obligatoire'],


            'ParamValues' => ['cette donnee est obligatoire'],


            'WirelessSSID' => ['cette donnee est obligatoire'],


            'WirelessKey' => ['cette donnee est obligatoire'],


            'WirelessAddr' => ['cette donnee est obligatoire'],


            'WirelessMask' => ['cette donnee est obligatoire'],


            'WirelessGateWay' => ['cette donnee est obligatoire'],


            'IsWireless' => ['cette donnee est obligatoire'],


            'ACFun' => ['cette donnee est obligatoire'],


            'BiometricType' => ['cette donnee est obligatoire'],


            'BiometricVersion' => ['cette donnee est obligatoire'],


            'BiometricMaxCount' => ['cette donnee est obligatoire'],


            'BiometricUsedCount' => ['cette donnee est obligatoire'],


            'WIFI' => ['cette donnee est obligatoire'],


            'WIFIOn' => ['cette donnee est obligatoire'],


            'WIFIDHCP' => ['cette donnee est obligatoire'],


            'IsExtend' => ['cette donnee est obligatoire'],


            'identifiants_sadge' => ['cette donnee est obligatoire'],


            'creat_by' => ['cette donnee est obligatoire'],


        ])->validate();


        $extra_data = array_diff($envoyer, $champsRechercher);


        if (array_key_exists("ID", $data)) {


            if (!empty($data['ID'])) {

                $Machines->ID = $data['ID'];

            }

        }


        if (array_key_exists("MachineAlias", $data)) {


            if (!empty($data['MachineAlias'])) {

                $Machines->MachineAlias = $data['MachineAlias'];

            }

        }


        if (array_key_exists("ConnectType", $data)) {


            if (!empty($data['ConnectType'])) {

                $Machines->ConnectType = $data['ConnectType'];

            }

        }


        if (array_key_exists("IP", $data)) {


            if (!empty($data['IP'])) {

                $Machines->IP = $data['IP'];

            }

        }


        if (array_key_exists("SerialPort", $data)) {


            if (!empty($data['SerialPort'])) {

                $Machines->SerialPort = $data['SerialPort'];

            }

        }


        if (array_key_exists("Port", $data)) {


            if (!empty($data['Port'])) {

                $Machines->Port = $data['Port'];

            }

        }


        if (array_key_exists("Baudrate", $data)) {


            if (!empty($data['Baudrate'])) {

                $Machines->Baudrate = $data['Baudrate'];

            }

        }


        if (array_key_exists("MachineNumber", $data)) {


            if (!empty($data['MachineNumber'])) {

                $Machines->MachineNumber = $data['MachineNumber'];

            }

        }


        if (array_key_exists("IsHost", $data)) {


            if (!empty($data['IsHost'])) {

                $Machines->IsHost = $data['IsHost'];

            }

        }


        if (array_key_exists("Enabled", $data)) {


            if (!empty($data['Enabled'])) {

                $Machines->Enabled = $data['Enabled'];

            }

        }


        if (array_key_exists("CommPassword", $data)) {


            if (!empty($data['CommPassword'])) {

                $Machines->CommPassword = $data['CommPassword'];

            }

        }


        if (array_key_exists("UILanguage", $data)) {


            if (!empty($data['UILanguage'])) {

                $Machines->UILanguage = $data['UILanguage'];

            }

        }


        if (array_key_exists("DateFormat", $data)) {


            if (!empty($data['DateFormat'])) {

                $Machines->DateFormat = $data['DateFormat'];

            }

        }


        if (array_key_exists("InOutRecordWarn", $data)) {


            if (!empty($data['InOutRecordWarn'])) {

                $Machines->InOutRecordWarn = $data['InOutRecordWarn'];

            }

        }


        if (array_key_exists("Idle", $data)) {


            if (!empty($data['Idle'])) {

                $Machines->Idle = $data['Idle'];

            }

        }


        if (array_key_exists("Voice", $data)) {


            if (!empty($data['Voice'])) {

                $Machines->Voice = $data['Voice'];

            }

        }


        if (array_key_exists("managercount", $data)) {


            if (!empty($data['managercount'])) {

                $Machines->managercount = $data['managercount'];

            }

        }


        if (array_key_exists("usercount", $data)) {


            if (!empty($data['usercount'])) {

                $Machines->usercount = $data['usercount'];

            }

        }


        if (array_key_exists("fingercount", $data)) {


            if (!empty($data['fingercount'])) {

                $Machines->fingercount = $data['fingercount'];

            }

        }


        if (array_key_exists("SecretCount", $data)) {


            if (!empty($data['SecretCount'])) {

                $Machines->SecretCount = $data['SecretCount'];

            }

        }


        if (array_key_exists("FirmwareVersion", $data)) {


            if (!empty($data['FirmwareVersion'])) {

                $Machines->FirmwareVersion = $data['FirmwareVersion'];

            }

        }


        if (array_key_exists("ProductType", $data)) {


            if (!empty($data['ProductType'])) {

                $Machines->ProductType = $data['ProductType'];

            }

        }


        if (array_key_exists("LockControl", $data)) {


            if (!empty($data['LockControl'])) {

                $Machines->LockControl = $data['LockControl'];

            }

        }


        if (array_key_exists("Purpose", $data)) {


            if (!empty($data['Purpose'])) {

                $Machines->Purpose = $data['Purpose'];

            }

        }


        if (array_key_exists("ProduceKind", $data)) {


            if (!empty($data['ProduceKind'])) {

                $Machines->ProduceKind = $data['ProduceKind'];

            }

        }


        if (array_key_exists("sn", $data)) {


            if (!empty($data['sn'])) {

                $Machines->sn = $data['sn'];

            }

        }


        if (array_key_exists("PhotoStamp", $data)) {


            if (!empty($data['PhotoStamp'])) {

                $Machines->PhotoStamp = $data['PhotoStamp'];

            }

        }


        if (array_key_exists("IsIfChangeConfigServer2", $data)) {


            if (!empty($data['IsIfChangeConfigServer2'])) {

                $Machines->IsIfChangeConfigServer2 = $data['IsIfChangeConfigServer2'];

            }

        }


        if (array_key_exists("pushver", $data)) {


            if (!empty($data['pushver'])) {

                $Machines->pushver = $data['pushver'];

            }

        }


        if (array_key_exists("change_operator", $data)) {


            if (!empty($data['change_operator'])) {

                $Machines->change_operator = $data['change_operator'];

            }

        }


        if (array_key_exists("change_time", $data)) {


            if (!empty($data['change_time'])) {

                $Machines->change_time = $data['change_time'];

            }

        }


        if (array_key_exists("create_operator", $data)) {


            if (!empty($data['create_operator'])) {

                $Machines->create_operator = $data['create_operator'];

            }

        }


        if (array_key_exists("create_time", $data)) {


            if (!empty($data['create_time'])) {

                $Machines->create_time = $data['create_time'];

            }

        }


        if (array_key_exists("delete_operator", $data)) {


            if (!empty($data['delete_operator'])) {

                $Machines->delete_operator = $data['delete_operator'];

            }

        }


        if (array_key_exists("delete_time", $data)) {


            if (!empty($data['delete_time'])) {

                $Machines->delete_time = $data['delete_time'];

            }

        }


        if (array_key_exists("status", $data)) {


            if (!empty($data['status'])) {

                $Machines->status = $data['status'];

            }

        }


        if (array_key_exists("device_type", $data)) {


            if (!empty($data['device_type'])) {

                $Machines->device_type = $data['device_type'];

            }

        }


        if (array_key_exists("last_activity", $data)) {


            if (!empty($data['last_activity'])) {

                $Machines->last_activity = $data['last_activity'];

            }

        }


        if (array_key_exists("trans_times", $data)) {


            if (!empty($data['trans_times'])) {

                $Machines->trans_times = $data['trans_times'];

            }

        }


        if (array_key_exists("TransInterval", $data)) {


            if (!empty($data['TransInterval'])) {

                $Machines->TransInterval = $data['TransInterval'];

            }

        }


        if (array_key_exists("log_stamp", $data)) {


            if (!empty($data['log_stamp'])) {

                $Machines->log_stamp = $data['log_stamp'];

            }

        }


        if (array_key_exists("oplog_stamp", $data)) {


            if (!empty($data['oplog_stamp'])) {

                $Machines->oplog_stamp = $data['oplog_stamp'];

            }

        }


        if (array_key_exists("photo_stamp", $data)) {


            if (!empty($data['photo_stamp'])) {

                $Machines->photo_stamp = $data['photo_stamp'];

            }

        }


        if (array_key_exists("UpdateDB", $data)) {


            if (!empty($data['UpdateDB'])) {

                $Machines->UpdateDB = $data['UpdateDB'];

            }

        }


        if (array_key_exists("device_name", $data)) {


            if (!empty($data['device_name'])) {

                $Machines->device_name = $data['device_name'];

            }

        }


        if (array_key_exists("transaction_count", $data)) {


            if (!empty($data['transaction_count'])) {

                $Machines->transaction_count = $data['transaction_count'];

            }

        }


        if (array_key_exists("main_time", $data)) {


            if (!empty($data['main_time'])) {

                $Machines->main_time = $data['main_time'];

            }

        }


        if (array_key_exists("max_user_count", $data)) {


            if (!empty($data['max_user_count'])) {

                $Machines->max_user_count = $data['max_user_count'];

            }

        }


        if (array_key_exists("max_finger_count", $data)) {


            if (!empty($data['max_finger_count'])) {

                $Machines->max_finger_count = $data['max_finger_count'];

            }

        }


        if (array_key_exists("max_attlog_count", $data)) {


            if (!empty($data['max_attlog_count'])) {

                $Machines->max_attlog_count = $data['max_attlog_count'];

            }

        }


        if (array_key_exists("alg_ver", $data)) {


            if (!empty($data['alg_ver'])) {

                $Machines->alg_ver = $data['alg_ver'];

            }

        }


        if (array_key_exists("flash_size", $data)) {


            if (!empty($data['flash_size'])) {

                $Machines->flash_size = $data['flash_size'];

            }

        }


        if (array_key_exists("free_flash_size", $data)) {


            if (!empty($data['free_flash_size'])) {

                $Machines->free_flash_size = $data['free_flash_size'];

            }

        }


        if (array_key_exists("language", $data)) {


            if (!empty($data['language'])) {

                $Machines->language = $data['language'];

            }

        }


        if (array_key_exists("lng_encode", $data)) {


            if (!empty($data['lng_encode'])) {

                $Machines->lng_encode = $data['lng_encode'];

            }

        }


        if (array_key_exists("volume", $data)) {


            if (!empty($data['volume'])) {

                $Machines->volume = $data['volume'];

            }

        }


        if (array_key_exists("is_tft", $data)) {


            if (!empty($data['is_tft'])) {

                $Machines->is_tft = $data['is_tft'];

            }

        }


        if (array_key_exists("platform", $data)) {


            if (!empty($data['platform'])) {

                $Machines->platform = $data['platform'];

            }

        }


        if (array_key_exists("brightness", $data)) {


            if (!empty($data['brightness'])) {

                $Machines->brightness = $data['brightness'];

            }

        }


        if (array_key_exists("oem_vendor", $data)) {


            if (!empty($data['oem_vendor'])) {

                $Machines->oem_vendor = $data['oem_vendor'];

            }

        }


        if (array_key_exists("city", $data)) {


            if (!empty($data['city'])) {

                $Machines->city = $data['city'];

            }

        }


        if (array_key_exists("AccFun", $data)) {


            if (!empty($data['AccFun'])) {

                $Machines->AccFun = $data['AccFun'];

            }

        }


        if (array_key_exists("TZAdj", $data)) {


            if (!empty($data['TZAdj'])) {

                $Machines->TZAdj = $data['TZAdj'];

            }

        }


        if (array_key_exists("comm_type", $data)) {


            if (!empty($data['comm_type'])) {

                $Machines->comm_type = $data['comm_type'];

            }

        }


        if (array_key_exists("agent_ipaddress", $data)) {


            if (!empty($data['agent_ipaddress'])) {

                $Machines->agent_ipaddress = $data['agent_ipaddress'];

            }

        }


        if (array_key_exists("subnet_mask", $data)) {


            if (!empty($data['subnet_mask'])) {

                $Machines->subnet_mask = $data['subnet_mask'];

            }

        }


        if (array_key_exists("gateway", $data)) {


            if (!empty($data['gateway'])) {

                $Machines->gateway = $data['gateway'];

            }

        }


        if (array_key_exists("area_id", $data)) {


            if (!empty($data['area_id'])) {

                $Machines->area_id = $data['area_id'];

            }

        }


        if (array_key_exists("acpanel_type", $data)) {


            if (!empty($data['acpanel_type'])) {

                $Machines->acpanel_type = $data['acpanel_type'];

            }

        }


        if (array_key_exists("sync_time", $data)) {


            if (!empty($data['sync_time'])) {

                $Machines->sync_time = $data['sync_time'];

            }

        }


        if (array_key_exists("four_to_two", $data)) {


            if (!empty($data['four_to_two'])) {

                $Machines->four_to_two = $data['four_to_two'];

            }

        }


        if (array_key_exists("video_login", $data)) {


            if (!empty($data['video_login'])) {

                $Machines->video_login = $data['video_login'];

            }

        }


        if (array_key_exists("fp_mthreshold", $data)) {


            if (!empty($data['fp_mthreshold'])) {

                $Machines->fp_mthreshold = $data['fp_mthreshold'];

            }

        }


        if (array_key_exists("Fpversion", $data)) {


            if (!empty($data['Fpversion'])) {

                $Machines->Fpversion = $data['Fpversion'];

            }

        }


        if (array_key_exists("max_comm_size", $data)) {


            if (!empty($data['max_comm_size'])) {

                $Machines->max_comm_size = $data['max_comm_size'];

            }

        }


        if (array_key_exists("max_comm_count", $data)) {


            if (!empty($data['max_comm_count'])) {

                $Machines->max_comm_count = $data['max_comm_count'];

            }

        }


        if (array_key_exists("realtime", $data)) {


            if (!empty($data['realtime'])) {

                $Machines->realtime = $data['realtime'];

            }

        }


        if (array_key_exists("delay", $data)) {


            if (!empty($data['delay'])) {

                $Machines->delay = $data['delay'];

            }

        }


        if (array_key_exists("encrypt", $data)) {


            if (!empty($data['encrypt'])) {

                $Machines->encrypt = $data['encrypt'];

            }

        }


        if (array_key_exists("dstime_id", $data)) {


            if (!empty($data['dstime_id'])) {

                $Machines->dstime_id = $data['dstime_id'];

            }

        }


        if (array_key_exists("door_count", $data)) {


            if (!empty($data['door_count'])) {

                $Machines->door_count = $data['door_count'];

            }

        }


        if (array_key_exists("reader_count", $data)) {


            if (!empty($data['reader_count'])) {

                $Machines->reader_count = $data['reader_count'];

            }

        }


        if (array_key_exists("aux_in_count", $data)) {


            if (!empty($data['aux_in_count'])) {

                $Machines->aux_in_count = $data['aux_in_count'];

            }

        }


        if (array_key_exists("aux_out_count", $data)) {


            if (!empty($data['aux_out_count'])) {

                $Machines->aux_out_count = $data['aux_out_count'];

            }

        }


        if (array_key_exists("IsOnlyRFMachine", $data)) {


            if (!empty($data['IsOnlyRFMachine'])) {

                $Machines->IsOnlyRFMachine = $data['IsOnlyRFMachine'];

            }

        }


        if (array_key_exists("alias", $data)) {


            if (!empty($data['alias'])) {

                $Machines->alias = $data['alias'];

            }

        }


        if (array_key_exists("ipaddress", $data)) {


            if (!empty($data['ipaddress'])) {

                $Machines->ipaddress = $data['ipaddress'];

            }

        }


        if (array_key_exists("com_port", $data)) {


            if (!empty($data['com_port'])) {

                $Machines->com_port = $data['com_port'];

            }

        }


        if (array_key_exists("com_address", $data)) {


            if (!empty($data['com_address'])) {

                $Machines->com_address = $data['com_address'];

            }

        }


        if (array_key_exists("DeviceNetmask", $data)) {


            if (!empty($data['DeviceNetmask'])) {

                $Machines->DeviceNetmask = $data['DeviceNetmask'];

            }

        }


        if (array_key_exists("DeviceGetway", $data)) {


            if (!empty($data['DeviceGetway'])) {

                $Machines->DeviceGetway = $data['DeviceGetway'];

            }

        }


        if (array_key_exists("SimpleEventType", $data)) {


            if (!empty($data['SimpleEventType'])) {

                $Machines->SimpleEventType = $data['SimpleEventType'];

            }

        }


        if (array_key_exists("FvFunOn", $data)) {


            if (!empty($data['FvFunOn'])) {

                $Machines->FvFunOn = $data['FvFunOn'];

            }

        }


        if (array_key_exists("fvcount", $data)) {


            if (!empty($data['fvcount'])) {

                $Machines->fvcount = $data['fvcount'];

            }

        }


        if (array_key_exists("deviceOption", $data)) {


            if (!empty($data['deviceOption'])) {

                $Machines->deviceOption = $data['deviceOption'];

            }

        }


        if (array_key_exists("DevSDKType", $data)) {


            if (!empty($data['DevSDKType'])) {

                $Machines->DevSDKType = $data['DevSDKType'];

            }

        }


        if (array_key_exists("UTableDesc", $data)) {


            if (!empty($data['UTableDesc'])) {

                $Machines->UTableDesc = $data['UTableDesc'];

            }

        }


        if (array_key_exists("IsTFTMachine", $data)) {


            if (!empty($data['IsTFTMachine'])) {

                $Machines->IsTFTMachine = $data['IsTFTMachine'];

            }

        }


        if (array_key_exists("PinWidth", $data)) {


            if (!empty($data['PinWidth'])) {

                $Machines->PinWidth = $data['PinWidth'];

            }

        }


        if (array_key_exists("UserExtFmt", $data)) {


            if (!empty($data['UserExtFmt'])) {

                $Machines->UserExtFmt = $data['UserExtFmt'];

            }

        }


        if (array_key_exists("FP1_NThreshold", $data)) {


            if (!empty($data['FP1_NThreshold'])) {

                $Machines->FP1_NThreshold = $data['FP1_NThreshold'];

            }

        }


        if (array_key_exists("FP1_1Threshold", $data)) {


            if (!empty($data['FP1_1Threshold'])) {

                $Machines->FP1_1Threshold = $data['FP1_1Threshold'];

            }

        }


        if (array_key_exists("Face1_NThreshold", $data)) {


            if (!empty($data['Face1_NThreshold'])) {

                $Machines->Face1_NThreshold = $data['Face1_NThreshold'];

            }

        }


        if (array_key_exists("Face1_1Threshold", $data)) {


            if (!empty($data['Face1_1Threshold'])) {

                $Machines->Face1_1Threshold = $data['Face1_1Threshold'];

            }

        }


        if (array_key_exists("Only1_1Mode", $data)) {


            if (!empty($data['Only1_1Mode'])) {

                $Machines->Only1_1Mode = $data['Only1_1Mode'];

            }

        }


        if (array_key_exists("OnlyCheckCard", $data)) {


            if (!empty($data['OnlyCheckCard'])) {

                $Machines->OnlyCheckCard = $data['OnlyCheckCard'];

            }

        }


        if (array_key_exists("MifireMustRegistered", $data)) {


            if (!empty($data['MifireMustRegistered'])) {

                $Machines->MifireMustRegistered = $data['MifireMustRegistered'];

            }

        }


        if (array_key_exists("RFCardOn", $data)) {


            if (!empty($data['RFCardOn'])) {

                $Machines->RFCardOn = $data['RFCardOn'];

            }

        }


        if (array_key_exists("Mifire", $data)) {


            if (!empty($data['Mifire'])) {

                $Machines->Mifire = $data['Mifire'];

            }

        }


        if (array_key_exists("MifireId", $data)) {


            if (!empty($data['MifireId'])) {

                $Machines->MifireId = $data['MifireId'];

            }

        }


        if (array_key_exists("NetOn", $data)) {


            if (!empty($data['NetOn'])) {

                $Machines->NetOn = $data['NetOn'];

            }

        }


        if (array_key_exists("RS232On", $data)) {


            if (!empty($data['RS232On'])) {

                $Machines->RS232On = $data['RS232On'];

            }

        }


        if (array_key_exists("RS485On", $data)) {


            if (!empty($data['RS485On'])) {

                $Machines->RS485On = $data['RS485On'];

            }

        }


        if (array_key_exists("FreeType", $data)) {


            if (!empty($data['FreeType'])) {

                $Machines->FreeType = $data['FreeType'];

            }

        }


        if (array_key_exists("FreeTime", $data)) {


            if (!empty($data['FreeTime'])) {

                $Machines->FreeTime = $data['FreeTime'];

            }

        }


        if (array_key_exists("NoDisplayFun", $data)) {


            if (!empty($data['NoDisplayFun'])) {

                $Machines->NoDisplayFun = $data['NoDisplayFun'];

            }

        }


        if (array_key_exists("VoiceTipsOn", $data)) {


            if (!empty($data['VoiceTipsOn'])) {

                $Machines->VoiceTipsOn = $data['VoiceTipsOn'];

            }

        }


        if (array_key_exists("TOMenu", $data)) {


            if (!empty($data['TOMenu'])) {

                $Machines->TOMenu = $data['TOMenu'];

            }

        }


        if (array_key_exists("StdVolume", $data)) {


            if (!empty($data['StdVolume'])) {

                $Machines->StdVolume = $data['StdVolume'];

            }

        }


        if (array_key_exists("VRYVH", $data)) {


            if (!empty($data['VRYVH'])) {

                $Machines->VRYVH = $data['VRYVH'];

            }

        }


        if (array_key_exists("KeyPadBeep", $data)) {


            if (!empty($data['KeyPadBeep'])) {

                $Machines->KeyPadBeep = $data['KeyPadBeep'];

            }

        }


        if (array_key_exists("BatchUpdate", $data)) {


            if (!empty($data['BatchUpdate'])) {

                $Machines->BatchUpdate = $data['BatchUpdate'];

            }

        }


        if (array_key_exists("CardFun", $data)) {


            if (!empty($data['CardFun'])) {

                $Machines->CardFun = $data['CardFun'];

            }

        }


        if (array_key_exists("FaceFunOn", $data)) {


            if (!empty($data['FaceFunOn'])) {

                $Machines->FaceFunOn = $data['FaceFunOn'];

            }

        }


        if (array_key_exists("FaceCount", $data)) {


            if (!empty($data['FaceCount'])) {

                $Machines->FaceCount = $data['FaceCount'];

            }

        }


        if (array_key_exists("TimeAPBFunOn", $data)) {


            if (!empty($data['TimeAPBFunOn'])) {

                $Machines->TimeAPBFunOn = $data['TimeAPBFunOn'];

            }

        }


        if (array_key_exists("FingerFunOn", $data)) {


            if (!empty($data['FingerFunOn'])) {

                $Machines->FingerFunOn = $data['FingerFunOn'];

            }

        }


        if (array_key_exists("CompatOldFirmware", $data)) {


            if (!empty($data['CompatOldFirmware'])) {

                $Machines->CompatOldFirmware = $data['CompatOldFirmware'];

            }

        }


        if (array_key_exists("ParamValues", $data)) {


            if (!empty($data['ParamValues'])) {

                $Machines->ParamValues = $data['ParamValues'];

            }

        }


        if (array_key_exists("WirelessSSID", $data)) {


            if (!empty($data['WirelessSSID'])) {

                $Machines->WirelessSSID = $data['WirelessSSID'];

            }

        }


        if (array_key_exists("WirelessKey", $data)) {


            if (!empty($data['WirelessKey'])) {

                $Machines->WirelessKey = $data['WirelessKey'];

            }

        }


        if (array_key_exists("WirelessAddr", $data)) {


            if (!empty($data['WirelessAddr'])) {

                $Machines->WirelessAddr = $data['WirelessAddr'];

            }

        }


        if (array_key_exists("WirelessMask", $data)) {


            if (!empty($data['WirelessMask'])) {

                $Machines->WirelessMask = $data['WirelessMask'];

            }

        }


        if (array_key_exists("WirelessGateWay", $data)) {


            if (!empty($data['WirelessGateWay'])) {

                $Machines->WirelessGateWay = $data['WirelessGateWay'];

            }

        }


        if (array_key_exists("IsWireless", $data)) {


            if (!empty($data['IsWireless'])) {

                $Machines->IsWireless = $data['IsWireless'];

            }

        }


        if (array_key_exists("ACFun", $data)) {


            if (!empty($data['ACFun'])) {

                $Machines->ACFun = $data['ACFun'];

            }

        }


        if (array_key_exists("BiometricType", $data)) {


            if (!empty($data['BiometricType'])) {

                $Machines->BiometricType = $data['BiometricType'];

            }

        }


        if (array_key_exists("BiometricVersion", $data)) {


            if (!empty($data['BiometricVersion'])) {

                $Machines->BiometricVersion = $data['BiometricVersion'];

            }

        }


        if (array_key_exists("BiometricMaxCount", $data)) {


            if (!empty($data['BiometricMaxCount'])) {

                $Machines->BiometricMaxCount = $data['BiometricMaxCount'];

            }

        }


        if (array_key_exists("BiometricUsedCount", $data)) {


            if (!empty($data['BiometricUsedCount'])) {

                $Machines->BiometricUsedCount = $data['BiometricUsedCount'];

            }

        }


        if (array_key_exists("WIFI", $data)) {


            if (!empty($data['WIFI'])) {

                $Machines->WIFI = $data['WIFI'];

            }

        }


        if (array_key_exists("WIFIOn", $data)) {


            if (!empty($data['WIFIOn'])) {

                $Machines->WIFIOn = $data['WIFIOn'];

            }

        }


        if (array_key_exists("WIFIDHCP", $data)) {


            if (!empty($data['WIFIDHCP'])) {

                $Machines->WIFIDHCP = $data['WIFIDHCP'];

            }

        }


        if (array_key_exists("IsExtend", $data)) {


            if (!empty($data['IsExtend'])) {

                $Machines->IsExtend = $data['IsExtend'];

            }

        }


        if (array_key_exists("identifiants_sadge", $data)) {


            if (!empty($data['identifiants_sadge'])) {

                $Machines->identifiants_sadge = $data['identifiants_sadge'];

            }

        }


        if (array_key_exists("creat_by", $data)) {


            if (!empty($data['creat_by'])) {

                $Machines->creat_by = $data['creat_by'];

            }

        }


        $dat = [];

        foreach ($extra_data as $d) {

            $dat[$d] = $data[$d];

        }
        try {

            $Machines->extra_attributes["extra-data"] = $dat;


        } catch (Throwable $e) {
        }


        if (
            class_exists('\App\Http\Extras\MachineExtras') &&
            method_exists('\App\Http\Extras\MachineExtras', 'beforeSaveUpdate')
        ) {
            MachineExtras::beforeSaveUpdate($request, $Machines);
        }

        $canSave = true;
        if (
            class_exists('\App\Http\Extras\MachineExtras') &&
            method_exists('\App\Http\Extras\MachineExtras', 'canUpdate')
        ) {
            try {
                $canSave = MachineExtras::canUpdate($request, $Machines);
            } catch (Throwable $e) {

            }

        }


        if ($canSave) {
            $Machines->save();
        } else {
            return response()->json($Machines, 200);

        }


        $Machines = Machine::find($Machines->id);


        $newCrudData = [];

        $newCrudData['ID'] = $Machines->ID;
        $newCrudData['MachineAlias'] = $Machines->MachineAlias;
        $newCrudData['ConnectType'] = $Machines->ConnectType;
        $newCrudData['IP'] = $Machines->IP;
        $newCrudData['SerialPort'] = $Machines->SerialPort;
        $newCrudData['Port'] = $Machines->Port;
        $newCrudData['Baudrate'] = $Machines->Baudrate;
        $newCrudData['MachineNumber'] = $Machines->MachineNumber;
        $newCrudData['IsHost'] = $Machines->IsHost;
        $newCrudData['Enabled'] = $Machines->Enabled;
        $newCrudData['CommPassword'] = $Machines->CommPassword;
        $newCrudData['UILanguage'] = $Machines->UILanguage;
        $newCrudData['DateFormat'] = $Machines->DateFormat;
        $newCrudData['InOutRecordWarn'] = $Machines->InOutRecordWarn;
        $newCrudData['Idle'] = $Machines->Idle;
        $newCrudData['Voice'] = $Machines->Voice;
        $newCrudData['managercount'] = $Machines->managercount;
        $newCrudData['usercount'] = $Machines->usercount;
        $newCrudData['fingercount'] = $Machines->fingercount;
        $newCrudData['SecretCount'] = $Machines->SecretCount;
        $newCrudData['FirmwareVersion'] = $Machines->FirmwareVersion;
        $newCrudData['ProductType'] = $Machines->ProductType;
        $newCrudData['LockControl'] = $Machines->LockControl;
        $newCrudData['Purpose'] = $Machines->Purpose;
        $newCrudData['ProduceKind'] = $Machines->ProduceKind;
        $newCrudData['sn'] = $Machines->sn;
        $newCrudData['PhotoStamp'] = $Machines->PhotoStamp;
        $newCrudData['IsIfChangeConfigServer2'] = $Machines->IsIfChangeConfigServer2;
        $newCrudData['pushver'] = $Machines->pushver;
        $newCrudData['change_operator'] = $Machines->change_operator;
        $newCrudData['change_time'] = $Machines->change_time;
        $newCrudData['create_operator'] = $Machines->create_operator;
        $newCrudData['create_time'] = $Machines->create_time;
        $newCrudData['delete_operator'] = $Machines->delete_operator;
        $newCrudData['delete_time'] = $Machines->delete_time;
        $newCrudData['status'] = $Machines->status;
        $newCrudData['device_type'] = $Machines->device_type;
        $newCrudData['last_activity'] = $Machines->last_activity;
        $newCrudData['trans_times'] = $Machines->trans_times;
        $newCrudData['TransInterval'] = $Machines->TransInterval;
        $newCrudData['log_stamp'] = $Machines->log_stamp;
        $newCrudData['oplog_stamp'] = $Machines->oplog_stamp;
        $newCrudData['photo_stamp'] = $Machines->photo_stamp;
        $newCrudData['UpdateDB'] = $Machines->UpdateDB;
        $newCrudData['device_name'] = $Machines->device_name;
        $newCrudData['transaction_count'] = $Machines->transaction_count;
        $newCrudData['main_time'] = $Machines->main_time;
        $newCrudData['max_user_count'] = $Machines->max_user_count;
        $newCrudData['max_finger_count'] = $Machines->max_finger_count;
        $newCrudData['max_attlog_count'] = $Machines->max_attlog_count;
        $newCrudData['alg_ver'] = $Machines->alg_ver;
        $newCrudData['flash_size'] = $Machines->flash_size;
        $newCrudData['free_flash_size'] = $Machines->free_flash_size;
        $newCrudData['language'] = $Machines->language;
        $newCrudData['lng_encode'] = $Machines->lng_encode;
        $newCrudData['volume'] = $Machines->volume;
        $newCrudData['is_tft'] = $Machines->is_tft;
        $newCrudData['platform'] = $Machines->platform;
        $newCrudData['brightness'] = $Machines->brightness;
        $newCrudData['oem_vendor'] = $Machines->oem_vendor;
        $newCrudData['city'] = $Machines->city;
        $newCrudData['AccFun'] = $Machines->AccFun;
        $newCrudData['TZAdj'] = $Machines->TZAdj;
        $newCrudData['comm_type'] = $Machines->comm_type;
        $newCrudData['agent_ipaddress'] = $Machines->agent_ipaddress;
        $newCrudData['subnet_mask'] = $Machines->subnet_mask;
        $newCrudData['gateway'] = $Machines->gateway;
        $newCrudData['area_id'] = $Machines->area_id;
        $newCrudData['acpanel_type'] = $Machines->acpanel_type;
        $newCrudData['sync_time'] = $Machines->sync_time;
        $newCrudData['four_to_two'] = $Machines->four_to_two;
        $newCrudData['video_login'] = $Machines->video_login;
        $newCrudData['fp_mthreshold'] = $Machines->fp_mthreshold;
        $newCrudData['Fpversion'] = $Machines->Fpversion;
        $newCrudData['max_comm_size'] = $Machines->max_comm_size;
        $newCrudData['max_comm_count'] = $Machines->max_comm_count;
        $newCrudData['realtime'] = $Machines->realtime;
        $newCrudData['delay'] = $Machines->delay;
        $newCrudData['encrypt'] = $Machines->encrypt;
        $newCrudData['dstime_id'] = $Machines->dstime_id;
        $newCrudData['door_count'] = $Machines->door_count;
        $newCrudData['reader_count'] = $Machines->reader_count;
        $newCrudData['aux_in_count'] = $Machines->aux_in_count;
        $newCrudData['aux_out_count'] = $Machines->aux_out_count;
        $newCrudData['IsOnlyRFMachine'] = $Machines->IsOnlyRFMachine;
        $newCrudData['alias'] = $Machines->alias;
        $newCrudData['ipaddress'] = $Machines->ipaddress;
        $newCrudData['com_port'] = $Machines->com_port;
        $newCrudData['com_address'] = $Machines->com_address;
        $newCrudData['DeviceNetmask'] = $Machines->DeviceNetmask;
        $newCrudData['DeviceGetway'] = $Machines->DeviceGetway;
        $newCrudData['SimpleEventType'] = $Machines->SimpleEventType;
        $newCrudData['FvFunOn'] = $Machines->FvFunOn;
        $newCrudData['fvcount'] = $Machines->fvcount;
        $newCrudData['deviceOption'] = $Machines->deviceOption;
        $newCrudData['DevSDKType'] = $Machines->DevSDKType;
        $newCrudData['UTableDesc'] = $Machines->UTableDesc;
        $newCrudData['IsTFTMachine'] = $Machines->IsTFTMachine;
        $newCrudData['PinWidth'] = $Machines->PinWidth;
        $newCrudData['UserExtFmt'] = $Machines->UserExtFmt;
        $newCrudData['FP1_NThreshold'] = $Machines->FP1_NThreshold;
        $newCrudData['FP1_1Threshold'] = $Machines->FP1_1Threshold;
        $newCrudData['Face1_NThreshold'] = $Machines->Face1_NThreshold;
        $newCrudData['Face1_1Threshold'] = $Machines->Face1_1Threshold;
        $newCrudData['Only1_1Mode'] = $Machines->Only1_1Mode;
        $newCrudData['OnlyCheckCard'] = $Machines->OnlyCheckCard;
        $newCrudData['MifireMustRegistered'] = $Machines->MifireMustRegistered;
        $newCrudData['RFCardOn'] = $Machines->RFCardOn;
        $newCrudData['Mifire'] = $Machines->Mifire;
        $newCrudData['MifireId'] = $Machines->MifireId;
        $newCrudData['NetOn'] = $Machines->NetOn;
        $newCrudData['RS232On'] = $Machines->RS232On;
        $newCrudData['RS485On'] = $Machines->RS485On;
        $newCrudData['FreeType'] = $Machines->FreeType;
        $newCrudData['FreeTime'] = $Machines->FreeTime;
        $newCrudData['NoDisplayFun'] = $Machines->NoDisplayFun;
        $newCrudData['VoiceTipsOn'] = $Machines->VoiceTipsOn;
        $newCrudData['TOMenu'] = $Machines->TOMenu;
        $newCrudData['StdVolume'] = $Machines->StdVolume;
        $newCrudData['VRYVH'] = $Machines->VRYVH;
        $newCrudData['KeyPadBeep'] = $Machines->KeyPadBeep;
        $newCrudData['BatchUpdate'] = $Machines->BatchUpdate;
        $newCrudData['CardFun'] = $Machines->CardFun;
        $newCrudData['FaceFunOn'] = $Machines->FaceFunOn;
        $newCrudData['FaceCount'] = $Machines->FaceCount;
        $newCrudData['TimeAPBFunOn'] = $Machines->TimeAPBFunOn;
        $newCrudData['FingerFunOn'] = $Machines->FingerFunOn;
        $newCrudData['CompatOldFirmware'] = $Machines->CompatOldFirmware;
        $newCrudData['ParamValues'] = $Machines->ParamValues;
        $newCrudData['WirelessSSID'] = $Machines->WirelessSSID;
        $newCrudData['WirelessKey'] = $Machines->WirelessKey;
        $newCrudData['WirelessAddr'] = $Machines->WirelessAddr;
        $newCrudData['WirelessMask'] = $Machines->WirelessMask;
        $newCrudData['WirelessGateWay'] = $Machines->WirelessGateWay;
        $newCrudData['IsWireless'] = $Machines->IsWireless;
        $newCrudData['ACFun'] = $Machines->ACFun;
        $newCrudData['BiometricType'] = $Machines->BiometricType;
        $newCrudData['BiometricVersion'] = $Machines->BiometricVersion;
        $newCrudData['BiometricMaxCount'] = $Machines->BiometricMaxCount;
        $newCrudData['BiometricUsedCount'] = $Machines->BiometricUsedCount;
        $newCrudData['WIFI'] = $Machines->WIFI;
        $newCrudData['WIFIOn'] = $Machines->WIFIOn;
        $newCrudData['WIFIDHCP'] = $Machines->WIFIDHCP;
        $newCrudData['IsExtend'] = $Machines->IsExtend;
        $newCrudData['identifiants_sadge'] = $Machines->identifiants_sadge;
        $newCrudData['creat_by'] = $Machines->creat_by;


        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Machines', 'entite_cle' => $Machines->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);

        $response = $Machines->toArray();


        try {

            foreach ($Machines->extra_attributes["extra-data"] as $key => $dat) {
                $response[$key] = $dat;
            }


        } catch (Throwable $e) {
        }


        return response()->json($response, 200);


    }


    /**
     * Remove the specified resource from storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function delete(Request $request, Machine $Machines)
    {
        try {
            $can = Helpers::can('Supprimer des Machines');

            if (!$can) {
                return response()->json([], 200);
            }
        } catch (Throwable $e) {
        }

        $newCrudData = [];

        $newCrudData['ID'] = $Machines->ID;
        $newCrudData['MachineAlias'] = $Machines->MachineAlias;
        $newCrudData['ConnectType'] = $Machines->ConnectType;
        $newCrudData['IP'] = $Machines->IP;
        $newCrudData['SerialPort'] = $Machines->SerialPort;
        $newCrudData['Port'] = $Machines->Port;
        $newCrudData['Baudrate'] = $Machines->Baudrate;
        $newCrudData['MachineNumber'] = $Machines->MachineNumber;
        $newCrudData['IsHost'] = $Machines->IsHost;
        $newCrudData['Enabled'] = $Machines->Enabled;
        $newCrudData['CommPassword'] = $Machines->CommPassword;
        $newCrudData['UILanguage'] = $Machines->UILanguage;
        $newCrudData['DateFormat'] = $Machines->DateFormat;
        $newCrudData['InOutRecordWarn'] = $Machines->InOutRecordWarn;
        $newCrudData['Idle'] = $Machines->Idle;
        $newCrudData['Voice'] = $Machines->Voice;
        $newCrudData['managercount'] = $Machines->managercount;
        $newCrudData['usercount'] = $Machines->usercount;
        $newCrudData['fingercount'] = $Machines->fingercount;
        $newCrudData['SecretCount'] = $Machines->SecretCount;
        $newCrudData['FirmwareVersion'] = $Machines->FirmwareVersion;
        $newCrudData['ProductType'] = $Machines->ProductType;
        $newCrudData['LockControl'] = $Machines->LockControl;
        $newCrudData['Purpose'] = $Machines->Purpose;
        $newCrudData['ProduceKind'] = $Machines->ProduceKind;
        $newCrudData['sn'] = $Machines->sn;
        $newCrudData['PhotoStamp'] = $Machines->PhotoStamp;
        $newCrudData['IsIfChangeConfigServer2'] = $Machines->IsIfChangeConfigServer2;
        $newCrudData['pushver'] = $Machines->pushver;
        $newCrudData['change_operator'] = $Machines->change_operator;
        $newCrudData['change_time'] = $Machines->change_time;
        $newCrudData['create_operator'] = $Machines->create_operator;
        $newCrudData['create_time'] = $Machines->create_time;
        $newCrudData['delete_operator'] = $Machines->delete_operator;
        $newCrudData['delete_time'] = $Machines->delete_time;
        $newCrudData['status'] = $Machines->status;
        $newCrudData['device_type'] = $Machines->device_type;
        $newCrudData['last_activity'] = $Machines->last_activity;
        $newCrudData['trans_times'] = $Machines->trans_times;
        $newCrudData['TransInterval'] = $Machines->TransInterval;
        $newCrudData['log_stamp'] = $Machines->log_stamp;
        $newCrudData['oplog_stamp'] = $Machines->oplog_stamp;
        $newCrudData['photo_stamp'] = $Machines->photo_stamp;
        $newCrudData['UpdateDB'] = $Machines->UpdateDB;
        $newCrudData['device_name'] = $Machines->device_name;
        $newCrudData['transaction_count'] = $Machines->transaction_count;
        $newCrudData['main_time'] = $Machines->main_time;
        $newCrudData['max_user_count'] = $Machines->max_user_count;
        $newCrudData['max_finger_count'] = $Machines->max_finger_count;
        $newCrudData['max_attlog_count'] = $Machines->max_attlog_count;
        $newCrudData['alg_ver'] = $Machines->alg_ver;
        $newCrudData['flash_size'] = $Machines->flash_size;
        $newCrudData['free_flash_size'] = $Machines->free_flash_size;
        $newCrudData['language'] = $Machines->language;
        $newCrudData['lng_encode'] = $Machines->lng_encode;
        $newCrudData['volume'] = $Machines->volume;
        $newCrudData['is_tft'] = $Machines->is_tft;
        $newCrudData['platform'] = $Machines->platform;
        $newCrudData['brightness'] = $Machines->brightness;
        $newCrudData['oem_vendor'] = $Machines->oem_vendor;
        $newCrudData['city'] = $Machines->city;
        $newCrudData['AccFun'] = $Machines->AccFun;
        $newCrudData['TZAdj'] = $Machines->TZAdj;
        $newCrudData['comm_type'] = $Machines->comm_type;
        $newCrudData['agent_ipaddress'] = $Machines->agent_ipaddress;
        $newCrudData['subnet_mask'] = $Machines->subnet_mask;
        $newCrudData['gateway'] = $Machines->gateway;
        $newCrudData['area_id'] = $Machines->area_id;
        $newCrudData['acpanel_type'] = $Machines->acpanel_type;
        $newCrudData['sync_time'] = $Machines->sync_time;
        $newCrudData['four_to_two'] = $Machines->four_to_two;
        $newCrudData['video_login'] = $Machines->video_login;
        $newCrudData['fp_mthreshold'] = $Machines->fp_mthreshold;
        $newCrudData['Fpversion'] = $Machines->Fpversion;
        $newCrudData['max_comm_size'] = $Machines->max_comm_size;
        $newCrudData['max_comm_count'] = $Machines->max_comm_count;
        $newCrudData['realtime'] = $Machines->realtime;
        $newCrudData['delay'] = $Machines->delay;
        $newCrudData['encrypt'] = $Machines->encrypt;
        $newCrudData['dstime_id'] = $Machines->dstime_id;
        $newCrudData['door_count'] = $Machines->door_count;
        $newCrudData['reader_count'] = $Machines->reader_count;
        $newCrudData['aux_in_count'] = $Machines->aux_in_count;
        $newCrudData['aux_out_count'] = $Machines->aux_out_count;
        $newCrudData['IsOnlyRFMachine'] = $Machines->IsOnlyRFMachine;
        $newCrudData['alias'] = $Machines->alias;
        $newCrudData['ipaddress'] = $Machines->ipaddress;
        $newCrudData['com_port'] = $Machines->com_port;
        $newCrudData['com_address'] = $Machines->com_address;
        $newCrudData['DeviceNetmask'] = $Machines->DeviceNetmask;
        $newCrudData['DeviceGetway'] = $Machines->DeviceGetway;
        $newCrudData['SimpleEventType'] = $Machines->SimpleEventType;
        $newCrudData['FvFunOn'] = $Machines->FvFunOn;
        $newCrudData['fvcount'] = $Machines->fvcount;
        $newCrudData['deviceOption'] = $Machines->deviceOption;
        $newCrudData['DevSDKType'] = $Machines->DevSDKType;
        $newCrudData['UTableDesc'] = $Machines->UTableDesc;
        $newCrudData['IsTFTMachine'] = $Machines->IsTFTMachine;
        $newCrudData['PinWidth'] = $Machines->PinWidth;
        $newCrudData['UserExtFmt'] = $Machines->UserExtFmt;
        $newCrudData['FP1_NThreshold'] = $Machines->FP1_NThreshold;
        $newCrudData['FP1_1Threshold'] = $Machines->FP1_1Threshold;
        $newCrudData['Face1_NThreshold'] = $Machines->Face1_NThreshold;
        $newCrudData['Face1_1Threshold'] = $Machines->Face1_1Threshold;
        $newCrudData['Only1_1Mode'] = $Machines->Only1_1Mode;
        $newCrudData['OnlyCheckCard'] = $Machines->OnlyCheckCard;
        $newCrudData['MifireMustRegistered'] = $Machines->MifireMustRegistered;
        $newCrudData['RFCardOn'] = $Machines->RFCardOn;
        $newCrudData['Mifire'] = $Machines->Mifire;
        $newCrudData['MifireId'] = $Machines->MifireId;
        $newCrudData['NetOn'] = $Machines->NetOn;
        $newCrudData['RS232On'] = $Machines->RS232On;
        $newCrudData['RS485On'] = $Machines->RS485On;
        $newCrudData['FreeType'] = $Machines->FreeType;
        $newCrudData['FreeTime'] = $Machines->FreeTime;
        $newCrudData['NoDisplayFun'] = $Machines->NoDisplayFun;
        $newCrudData['VoiceTipsOn'] = $Machines->VoiceTipsOn;
        $newCrudData['TOMenu'] = $Machines->TOMenu;
        $newCrudData['StdVolume'] = $Machines->StdVolume;
        $newCrudData['VRYVH'] = $Machines->VRYVH;
        $newCrudData['KeyPadBeep'] = $Machines->KeyPadBeep;
        $newCrudData['BatchUpdate'] = $Machines->BatchUpdate;
        $newCrudData['CardFun'] = $Machines->CardFun;
        $newCrudData['FaceFunOn'] = $Machines->FaceFunOn;
        $newCrudData['FaceCount'] = $Machines->FaceCount;
        $newCrudData['TimeAPBFunOn'] = $Machines->TimeAPBFunOn;
        $newCrudData['FingerFunOn'] = $Machines->FingerFunOn;
        $newCrudData['CompatOldFirmware'] = $Machines->CompatOldFirmware;
        $newCrudData['ParamValues'] = $Machines->ParamValues;
        $newCrudData['WirelessSSID'] = $Machines->WirelessSSID;
        $newCrudData['WirelessKey'] = $Machines->WirelessKey;
        $newCrudData['WirelessAddr'] = $Machines->WirelessAddr;
        $newCrudData['WirelessMask'] = $Machines->WirelessMask;
        $newCrudData['WirelessGateWay'] = $Machines->WirelessGateWay;
        $newCrudData['IsWireless'] = $Machines->IsWireless;
        $newCrudData['ACFun'] = $Machines->ACFun;
        $newCrudData['BiometricType'] = $Machines->BiometricType;
        $newCrudData['BiometricVersion'] = $Machines->BiometricVersion;
        $newCrudData['BiometricMaxCount'] = $Machines->BiometricMaxCount;
        $newCrudData['BiometricUsedCount'] = $Machines->BiometricUsedCount;
        $newCrudData['WIFI'] = $Machines->WIFI;
        $newCrudData['WIFIOn'] = $Machines->WIFIOn;
        $newCrudData['WIFIDHCP'] = $Machines->WIFIDHCP;
        $newCrudData['IsExtend'] = $Machines->IsExtend;
        $newCrudData['identifiants_sadge'] = $Machines->identifiants_sadge;
        $newCrudData['creat_by'] = $Machines->creat_by;


        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Machines', 'entite_cle' => $Machines->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);


        $canSave = true;
        if (
            class_exists('\App\Http\Extras\MachineExtras') &&
            method_exists('\App\Http\Extras\MachineExtras', 'canDelete')
        ) {
            try {
                $canSave = MachineExtras::canDelete($request, $Machines);
            } catch (Throwable $e) {

            }

        }


        if ($canSave) {
            $Machines->delete();
        } else {
            return response()->json($Machines, 200);

        }


        return response()->json([], 200);


    }


    public function action(Request $request)
    {


        $action = $request->get('action', 'aucun');
        $actioner = new MachinesActions();
        $response = $actioner->$action($request);


        return response()->json($response, 202);
    }

}
