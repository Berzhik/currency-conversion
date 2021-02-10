<?php

namespace Tests\Unit\Repository\Currency;

use App\Models\Currency\ExchangeHistory;
use App\Repository\Currency\ExchangeHistoryRepository;
use Database\Seeders\Currency\ExchangeHistorySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExchangeHistoryRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var boolean
     */
    protected $seed = true;

    /**
     * @var string
     */
    protected $seeder = ExchangeHistorySeeder::class;

    /**
     * @var ExchangeHistoryRepository
     */
    private $exchangeHistoryRepository;

    /**
     * @inheritDoc
     */
    public function setUp() : void
    {
        parent::setUp();

        $this->exchangeHistoryRepository = $this->app->make('App\Repository\Currency\ExchangeHistoryRepository');
    }

    /**
     * @return void
     */
    public function test_most_popular_destination()
    {
        $mostPopular = $this->exchangeHistoryRepository->mostPopularDestination();

        $this->assertEquals('EUR', $mostPopular);
    }

    /**
     * @return void
     */
    public function test_total_requests()
    {
        $totalRequests = $this->exchangeHistoryRepository->totalRequests();

        $this->assertEquals(5, $totalRequests);
    }
    
    /**
     * @return void
     */
    public function test_add_record()
    {
        $data = [
            'source' => 'EUR',
            'destination' => 'USD',
            'amount' => 186
        ];

        $this->exchangeHistoryRepository->addRecord($data);

        $this->assertDatabaseHas(ExchangeHistory::TABLE_NAME, $data);
    }
}
