<?php

namespace App\Console\Commands;

use App\Services\CampaignService;
use Illuminate\Console\Command;
use App\Services\CronOffreService;
use App\Services\SmsService;
use App\Models\CampaignHistorique;
use Illuminate\Support\Facades\Log;
class BirthdayCampaign extends Command
{
    /**
     * Create a new command instance.
     *
     * @return void
     */
     
     protected $cronOffreService;
     protected $campaignService;
     protected $smsService;

    public function __construct(
         CronOffreService $cronOffreService,
        CampaignService $campaignService,
        SmsService $smsService)
    {
        $this->cronOffreService = $cronOffreService;
        $this->campaignService = $campaignService;
        $this->smsService = $smsService;
        parent::__construct();
    }
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'birthday:campaign';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
  
    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
       Log::info("Start of birthday campagne");
        $customers = $this->cronOffreService->getCustomerByBirthday();
        Log::info($customers);
        Log::info("Customers fetched");
        Log::info("Historique Campaign will be created now");
         $this->campaignService->createCampaign($customers);
        Log::info("Historique Campaign will be created now");
        $data = CampaignHistorique::all();
       // Log::info("Start sending sms");
        //$this->smsService->sendSms($data);
    }
}
