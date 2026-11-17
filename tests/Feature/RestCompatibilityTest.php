<?php

namespace Plutuss\AMember\Tests\Feature;

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use InvalidArgumentException;
use Plutuss\AMember\Clients\AMemberClient;
use Plutuss\AMember\Facades\AMember;
use Plutuss\AMember\Tests\TestCase;

class RestCompatibilityTest extends TestCase
{
    public function test_xml_and_serialized_responses_preserve_the_wire_body(): void
    {
        foreach (['xml' => '<response><_total>0</_total></response>', 'serialize' => 'a:1:{s:6:"_total";i:0;}'] as $format => $body) {
            Http::fake(['*' => Http::response($body, 200)]);
            $result = (new AMemberClient())->setOption('/users')->format($format)->sendGet();
            $this->assertSame(['status' => 200, 'data' => $body], $result);
            Http::assertSent(fn (Request $request) => $request['_format'] === $format);
        }
    }

    public function test_check_access_uses_get_and_only_its_own_parameters(): void
    {
        Http::fake(['*' => Http::response(['ok' => true], 200)]);
        $auth = AMember::auth()->format('xml')->count(1)->page(5)->filter(['active' => 1]);

        $calls = [
            ['byLoginPassIp', ['alice', 'secret', '127.0.0.1'], 'by-login-pass-ip', ['login' => 'alice', 'pass' => 'secret', 'ip' => '127.0.0.1']],
            ['byLoginPass', ['alice', 'secret'], 'by-login-pass', ['login' => 'alice', 'pass' => 'secret']],
            ['byUsername', ['alice'], 'by-login', ['login' => 'alice']],
            ['byEmailAddress', ['alice@example.com'], 'by-email', ['email' => 'alice@example.com']],
            ['restorePassword', ['alice'], 'send-pass', ['login' => 'alice']],
        ];
        foreach ($calls as [$method, $arguments, $endpoint, $params]) {
            $this->assertSame(['status' => 200, 'data' => ['ok' => true]], $auth->{$method}(...$arguments));
            Http::assertSent(fn (Request $request) => $request->method() === 'GET'
                && strtok($request->url(), '?') === 'https://amember.test/api/check-access/' . $endpoint
                && $request->data() === $params);
        }
        Http::assertSentCount(5);
    }

    public function test_user_groups_and_access_deletion(): void
    {
        Http::fake(['*' => Http::response([], 200)]);
        AMember::users()->getUserGroups();
        AMember::users()->getUserGroups(7);
        AMember::access()->deleteAccess(51);

        Http::assertSent(fn (Request $request) => $request->method() === 'GET'
            && strtok($request->url(), '?') === 'https://amember.test/api/user-groups');
        Http::assertSent(fn (Request $request) => $request->method() === 'GET'
            && strtok($request->url(), '?') === 'https://amember.test/api/user-groups/7');
        Http::assertSent(fn (Request $request) => $request->method() === 'DELETE'
            && $request->url() === 'https://amember.test/api/access/51');
        Http::assertSentCount(3);
    }

    public function test_nested_invoice_creation_is_separate_from_nested_read_options(): void
    {
        Http::fake(['*' => Http::response([], 200)]);
        $nested = [
            'invoice-items' => [['item_id' => 1, 'item_type' => 'product', 'qty' => 1]],
            'invoice-payments' => [['amount' => '22.00', 'currency' => 'USD']],
            'access' => [['user_id' => 1, 'product_id' => 1, 'begin_date' => '2026-01-01', 'expire_date' => '2026-02-01']],
        ];
        AMember::invoice()->nested(['access'])->setInvoice(['user_id' => 1, 'status' => 0, 'nested' => $nested]);

        Http::assertSent(fn (Request $request) => $request->method() === 'POST'
            && $request->url() === 'https://amember.test/api/invoices'
            && $request['nested'] === $nested && $request['_nested'] === ['access']
            && $request['status'] === 0
            && $request->hasHeader('Content-Type', 'application/x-www-form-urlencoded'));
    }

    public function test_product_creation_preserves_nested_billing_plans_and_categories(): void
    {
        Http::fake(['*' => Http::response([], 200)]);
        $nested = [
            'billing-plans' => [['first_price' => 10, 'first_period' => '1m', 'variable_qty' => 0]],
            'product-product-category' => [['product_category_id' => 2]],
        ];
        AMember::products()->setProducts(['title' => 'Example', 'nested' => $nested]);

        Http::assertSent(fn (Request $request) => $request->method() === 'POST'
            && $request->url() === 'https://amember.test/api/products'
            && $request['nested'] === $nested);
    }

    public function test_invalid_query_options_are_rejected_before_sending_requests(): void
    {
        Http::fake();
        foreach ([['format', 'yaml'], ['count', 0], ['count', 1001], ['page', -1], ['order', 'random']] as [$method, $value]) {
            try {
                (new AMemberClient())->{$method}($value);
                $this->fail('Expected invalid option to be rejected: ' . $method);
            } catch (InvalidArgumentException $exception) {
                $this->assertNotSame('', $exception->getMessage());
            }
        }
        Http::assertNothingSent();
    }

    public function test_query_option_boundaries_are_accepted(): void
    {
        Http::fake(['*' => Http::response([], 200)]);
        foreach ([1, 1000] as $count) {
            (new AMemberClient())->setOption('/users')->count($count)->page(0)->order('asc')->sendGet();
            Http::assertSent(fn (Request $request) => (int) $request['_count'] === $count && (int) $request['_page'] === 0);
        }
    }
}
