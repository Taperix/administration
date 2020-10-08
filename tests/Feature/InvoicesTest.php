<?php

namespace Tests\Feature;

use App\Models\Invoice;
use App\Models\Team;
use App\Models\User;
use App\States\Invoices\ReadyState;
use App\States\Invoices\SentState;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class InvoicesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var User
     */
    private $user;
    /**
     * @var Team
     */
    private $team;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = $user = User::factory()->create([
            'email' => 'lars.wiegers@taperix.com',
            'password' => Hash::make('yO$27$*z9njy@OJYEWvylo7')
        ]);
        $this->team = Team::factory()->create([
            'user_id' => $user->id,
            'name' => 'testuser\'s Team',
            'personal_team' => true
        ]);
    }

    /* @test */
    public function testIndexReturns200WhenNoInvoices()
    {
        Auth::loginUsingId($this->user->id);
        $response = $this->get(route('invoices.index'));

        $response->assertStatus(200);
    }

    /* @test */
    public function testIndexReturns200WithInvoices()
    {
        Invoice::factory()->count(20)->create();
        Auth::loginUsingId($this->user->id);
        $response = $this->get(route('invoices.index'));

        $response->assertStatus(200);
    }

    /* @test */
    public function testCreateReturns200WithInvoices()
    {
        Auth::loginUsingId($this->user->id);
        $response = $this->get(route('invoices.create'));

        $response->assertStatus(200);
    }

    /* @test */
    public function testShowReturns200WithInvoices()
    {
        $invoice = Invoice::factory()->create();
        Auth::loginUsingId($this->user->id);
        $response = $this->get(route('invoices.show', ['invoice' => $invoice]));
        $response->assertStatus(200);
    }

    /* @test */
    public function testCanCreateInvoice()
    {
        Auth::loginUsingId($this->user->id);

        $invoiceCountBefore = Invoice::count();

        $response = $this->post(route('invoices.store'), [
            'title' => 'testInvoice',
        ]);

        $response->assertStatus(302);
        $invoiceCountAfter = Invoice::count();
        $this->assertNotSame($invoiceCountBefore, $invoiceCountAfter);
        $this->assertSame($invoiceCountBefore + 1, $invoiceCountAfter);
    }

    /* @test */
    public function testCanChangeStateToReady()
    {
        Auth::loginUsingId($this->user->id);

        $invoice = Invoice::factory()->create();
        $response = $this->put(route('invoices.states.ready', ['invoice' => $invoice]));

        $response->assertStatus(302);

        $this->assertSame($invoice->fresh()->state->getShortDescription(), (new ReadyState($invoice))->getShortDescription());
    }

    /* @test */
    public function testCanChangeStateToSent()
    {
        Auth::loginUsingId($this->user->id);

        $invoice = Invoice::factory()->create();
        $invoice->state->transitionTo(ReadyState::class);

        $this->put(route('invoices.states.sent', ['invoice' => $invoice]));

        $this->assertSame($invoice->fresh()->state->getShortDescription(), (new SentState($invoice))->getShortDescription());
    }
}
