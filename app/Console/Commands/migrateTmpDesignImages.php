<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Design;
use App\Models\DesignImage;
use App;
use File;

class migrateTmpDesignImages extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:tmp-design-images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrates the temporary design images to permanent location';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        $unknownDesigns = [];
        foreach (File::files(public_path('uploads/artwork-old')) as $file) {
            $artworkName = collect(explode('/', $file))->last();
            $this->line("Artwork File Name: " . $artworkName);
            $fileName = mt_rand() . '-' . date('d-m-Y-H-i-s') . '.' . pathinfo($artworkName, PATHINFO_EXTENSION);
            $design = Design::where('friendly_id', collect(explode('_', $artworkName))->first())->first();
            if ($design) {
                $filePath = $design->getImageDestinationPath() . '/' . $fileName;
                $this->line("Design ID: " . $design->friendly_id);
                $this->line("New File Path: " . $filePath);
                $designTmpImages = $design->images()->where('path', 'like', DesignImage::IMAGE_DESTINATION_TMP_PATH . '%')->get();
                if ($designTmpImages->count() > 0) {
                    $this->error("Temporary images found");
                    $newDestinationPath = public_path($design->getImageDestinationPath());
                    if (file_exists($newDestinationPath)) {
                        File::cleanDirectory($newDestinationPath);
                        $this->info("Cleaned permanent directory");
                    } else {
                        File::makeDirectory($newDestinationPath, 0755, true);
                        $this->info("Created permanent directory");
                    }
                    File::copy($file, public_path($filePath));
                    $this->info("Copied original artwork file into the permanent directory");
                    $this->line("Generating required images from the artwork");
                    $designImages = (object)App::make('App\Http\Controllers\DesignController')->processDesignImages(public_path($filePath));
                    $this->info("Generated required images from the artwork");
                    foreach ($designTmpImages as $tmpImage) {
                        $path = $tmpImage->path;
                        switch ($tmpImage->type_id) {
                            case DesignImage::TYPE_ORIGINAL:
                                $path = $designImages->actualImagePath;
                                break;
                            case DesignImage::TYPE_DUPLICATE:
                                $path = $designImages->filePath;
                                break;
                            case DesignImage::TYPE_HIGH_RESOLUTION:
                                $path = $designImages->highResolutionImagePath;
                                break;
                            case DesignImage::TYPE_THUMBNAIL:
                                $path = $designImages->thumbnailImagePath;
                                break;
                            case DesignImage::TYPE_WATERMARK:
                                $path = $designImages->watermarkImagePath;
                                break;
                            case DesignImage::TYPE_SIMPLE_MIRROR:
                                $path = $designImages->simpleMirrorImage;
                                break;
                            case DesignImage::TYPE_MIRROR:
                                $path = $designImages->mirrorImagePath;
                                break;
                            case DesignImage::TYPE_BASIC_REPEAT:
                                $path = $designImages->basicRepeatedImagePath;
                                break;
                            case DesignImage::TYPE_HALF_DROP:
                                $path = $designImages->halfDropRepeatedImagePath;
                                break;
                            case DesignImage::TYPE_HALF_BRICK:
                                $path = $designImages->halfBrickRepeatedImagePath;
                                break;
                        }
                        $tmpImage->update(['path' => $design->getImageDestinationPath() . '/' . collect(explode('/', $path))->last()]);
                    }
                    $this->info("Updated images path in the database");
                } else {
                    $this->info("No temporary images found");
                }
            } else {
                $this->error("Design not found.");
                $unknownDesigns[] = $artworkName;
            }
            $this->line("\n");
        }
        $this->error(arrayToString($unknownDesigns));
    }

}
