<?php

namespace App\Services\LoggingService;

// Framework
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;
use Exception;

class EventLogger
{

    protected $log_data;
    protected $events;

    protected $identifier;
    protected $storageDriver = 'system_event_logs';
    protected $fileName = null;
    protected $fileExtension = null;

    public function __construct(String $identifier, $storageDriver = null, Array $fileMeta)
    {
        // Check we have the required meta data, that will be used to create the file name.
        if(!isset($fileMeta['file_name']) or !isset($fileMeta['file_extension']))
        {
            throw new Exception("Missing required data from fileMeta.");
        }

        // Check an identifier is passed in, will be used when unique identity is required.
        if(!$identifier)
        {
            throw new Exception("Missing required parameter `identifier`.");
        }

        $this->identifier = $identifier;

        // After checking, we can now set the required variables local to this class instance.
        if($storageDriver)
        {
           $this->storageDriver = $storageDriver;
        }

        $this->fileName = $fileMeta['file_name'];
        $this->fileExtension = $fileMeta['file_extension'];

    }

    public function addEvent($class, $function, $message, $level)
    {
        $this->constructEvent(array_merge(
            $this->constructMetaData($class, $function),
            $this->constructMessage($message, $level)
        ));
    }

    private function constructEvent(Array $event)
    {
        $this->events[] = $event;
        $this->addEventToLog($event);
    }

    public function addEventToLog(Array $event)
    {
        $logRef         = $this->generateErrorRef();
        $logFileName    = $this->createOrRetrieveLogFile();

        $this->log_data = Storage::disk($this->storageDriver)->get($logFileName);
        $this->log_data = json_decode($this->log_data, true);

        isset($event['meta'])      && $this->writeMetaData($logRef, $event['meta']['class'], $event['meta']['function']);
        isset($event['message'])   && $this->writeMessage($logRef, $event['message']['message'], $event['message']['level']);
        isset($event['exception']) && $this->writeException($logRef, $event['exception']['message']);

        $this->log_data = json_encode($this->log_data);

        return Storage::disk($this->storageDriver)->put($logFileName, $this->log_data);
    }

    private function createOrRetrieveLogFile()
    {
        $fileNameWithExtension = ($this->fileName . $this->identifier . $this->fileExtension);
        Storage::disk($this->storageDriver)->put($fileNameWithExtension, "");
        return $fileNameWithExtension;
    }

    private function generateErrorRef(){
        return uniqid();
    }

    public function constructMetaData($class, $function){
        return ['meta' => compact('class', 'function')];
    }
    public function constructMessage($message, $level){
        return ['message' => compact('message', 'level')];
    }
    public function constructException($message){
        return ['exception' => compact('message')];
    }


    private function writeMessage($logRef, $message, $level){
        $this->log_data['messages'][] = [
            "log_ref"      => $logRef,
            "message"      => $message,
            "access_level" => $level
        ];
    }
    private function writeException($logRef, $message){
        $this->log_data['exceptions'][] = [
            "log_ref" => $logRef,
            "exception_message" => $message
        ];
    }
    private function writeMetaData($logRef, $class, $function){
        $this->log_data['meta_data'][] = [
            "log_ref"    => $logRef,
            "class_full" => $class,
            "class"      => (new \ReflectionClass($class))->getShortName(),
            "function"   => $function,
            "date_time"  => Carbon::now()->toDateTimeString()
        ];
    }

}
