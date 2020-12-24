<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ExportCatsCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'export:cats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export all cats';


    /**
     * Table helper
     *
     * @var \Symfony\Component\Console\Helper\TableHelper
     */
    protected $table;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
        {
        parent::__construct();
        }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire(){
        $output_path = $this->argument('file');
        $headers = array('Name', 'Date of Birth', 'Breed');
        $rows = self::getCatsData();
        if($output_path){
            $handle = fopen($output_path, 'w');
            if($this->option('headers')){
                fputcsv($handle, $headers);
            }
            foreach($rows as $row){
                fputcsv($handle, $row);
            }
            fclose($handle);
            $this->info("Exported list to $output_path");
        } else {
            $table = $this->getHelperSet()->get('table');
            $table->setHeaders($headers)->setRows($rows);
            $table->render($this->getOutput());
        }
    }

    /**
     * Returns all cats in the database
     *
     * @return array
     */
    protected function getCatsData() {
        $cats = Cat::with('breed', 'owner')->get();
        foreach($cats as $cat){
            $output[] = array($cat->name,$cat->date_of_birth, $cat->breed->name);
        }
        return $output;
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments() {
        return array(
            array('file', InputArgument::OPTIONAL, 'The output file', null),
        );
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions() {
        return array(
            array('headers', null, InputOption::VALUE_NONE, 'Display headers?', null),
        );
    }

}
