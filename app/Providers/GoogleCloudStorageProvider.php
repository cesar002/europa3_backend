<?php

namespace App\Providers;

use League\Flysystem\Filesystem;
use Google\Cloud\Storage\StorageClient;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use Superbalist\Flysystem\GoogleStorage\GoogleStorageAdapter;

class GoogleCloudStorageProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Storage::extend('gcs', function($app, $config){
			$storageClient = new StorageClient([
				'projectId' => $config['project_id'],
				'keyFilePath' => $config['key_file'],
			]);

			$bucket = $storageClient->bucket($config['bucket']);

			$adapter = new GoogleStorageAdapter($storageClient, $bucket);

			$filesystem = new Filesystem($adapter);

			return $filesystem;
		});
    }
}
