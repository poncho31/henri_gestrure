<?php

namespace App\Sources\AudioRecording\Devices;

use App\Sources\AudioRecording\Commands\PowershellCommand;
use RecursiveArrayIterator;
use RecursiveIteratorIterator;

class Devices
{

    public static function audio(string $type = 'all'): array
    {
        $audioDevicesWmiObject = self::_audioDevicesInfo_wmiObject();
        $audioDevicesPnpDevice = self::_audioDeviceNames_pnpDevice();
        $audioDevicesFFMPEG    = self::_audioDevicesInfo_ffmpeg();

        return [
            'wmiobject' => $audioDevicesWmiObject,
            'pnpdevice' => $audioDevicesPnpDevice,
            'ffmpeg'    => $audioDevicesFFMPEG,
        ];
    }

    public static function _audioDeviceNames_pnpDevice() : ?array {
        $cmdPath = (new PowershellCommand('FriendlyName', 'FriendlyName', 'like', '*zoom*', 'ConvertTo-Json'));
        $audioDevicesPnpDevice = shell_exec("powershell {$cmdPath->pnpDevice()}");
        $toArray = json_decode($audioDevicesPnpDevice, true);
        return array_column($toArray, 'FriendlyName');
    }

    public static function _audioDevicesInfo_wmiObject():?array{
        $cmdPath = (new PowershellCommand('*', 'Service', 'like', '*usbaudio*', 'ConvertTo-Json'));
        $audioDevicesWmiObject = shell_exec("powershell {$cmdPath->wmiObject()}");
        // Powershell
        $wmiObjectPnpEntity = [];
        foreach (json_decode($audioDevicesWmiObject, true) ?? [] as $device){
            // __SERVER
            $wmiObjectPnpEntity []= [
                'Server'        => $device['__SERVER']      ?? null,
                'Caption'       => $device['Caption']       ?? null,
                'CompatibleID'  => $device['CompatibleID']  ?? null,
                'Manufacturer'  => $device['Manufacturer']  ?? null,
                'Description'   => $device['Description']   ?? null,
                'DeviceID'      => $device['DeviceID']      ?? null,
                'Scope'         => $device['Scope']         ?? null,
                'Name'          => $device['Name']          ?? null,

            ];
        }
        return $wmiObjectPnpEntity;
    }

    public static function _audioDevicesInfo_ffmpeg(): ?array
    {
        $ffmpegData = shell_exec("powershell ffmpeg -list_devices true -f dshow -i dummy 2>&1");
        preg_match_all('~Alternative name "(.*)"~',$ffmpegData??'', $devices);
        $data = [];
        foreach (new RecursiveIteratorIterator(new RecursiveArrayIterator($devices)) as $device){
            $data []= $device ?? null;
        }
        return $data;
    }
}
