<?php

namespace App\Sources\AudioRecording\Commands;

class PowershellCommand
{
    private string $filepath;
    private string $convert;
    private string $select;
    private string $where;
    private string $command;

    public function __construct(?string $select = '*',?string $where = 'Service', ?string $operator ='like', ?string $element ='*usbaudio*',?string $convert = 'ConvertTo-Json'){
        $this->filepath = storage_path('temp\audioDevices.ps1');

        $this->where = empty($where)? '' :'| Where-Object {$_.'.$where.' -'.$operator.' \''.$element.'\'}';
        $this->select = empty($select)? '' :"| Select-Object $select";
        $this->convert = empty($convert)? '' :"| $convert";
        $this->command = "$this->where $this->select $this->convert";
    }

    public function create(string $library): string
    {
        file_put_contents($this->filepath, "$library  $this->command");
        return $this->filepath;
    }

    public function wmiObject(): string
    {
        file_put_contents($this->filepath, "Get-WmiObject Win32_PnPEntity  $this->command");
        return $this->filepath;
    }

    public function pnpDevice(): string
    {
        file_put_contents($this->filepath, "Get-PnpDevice $this->command");
        return $this->filepath;
//        "Get-PnpDevice | Where-Object{ $_.FriendlyName -like '*zoom*' } | ft Name"
    }


}
