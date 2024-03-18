<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

// Services
use App\Services\DataGenerationService\Class\DatasetGenerator;

class GenerateDatasetCommand extends Command
{
    protected $signature   = 'generate:dataset';
    protected $description = 'Generates a dataset of max of 200 records using the DatasetGenerator utility class.';

    public function handle()
    {
        $records = DatasetGenerator::generateRecords(10);

        if(!count($records))
        {
            $this->info('No records generated.');
        }

        // Define the path and filename for the JSON file
        $filePath = storage_path('app/generated_records.json'); // temporary path.

        // Convert the and save the records array into a file containing the JSON data.
        $jsonContent = json_encode($records, JSON_PRETTY_PRINT);
        file_put_contents($filePath, $jsonContent);

        // Output message including the file path
        $this->info('Generated ' . count($records) . ' records and stored them in ' . $filePath);
    }
}
