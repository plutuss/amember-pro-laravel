<?php

namespace Plutuss\AMember\Tests\Feature;

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Plutuss\AMember\Facades\AMember;
use Plutuss\AMember\Tests\TestCase;

class ResourceEndpointsTest extends TestCase
{
    public function test_resource_accessors_fetch_lists_and_individual_records(): void
    {
        $endpoints = [
            'userGroups' => 'user-groups', 'userNotes' => 'user-notes',
            'userConsent' => 'user-consent', 'billingPlans' => 'billing-plans',
            'productCategories' => 'product-category',
            'productCategoryRelations' => 'product-product-category',
            'invoiceItems' => 'invoice-items',
        ];
        Http::fake(['*' => Http::response(['_total' => 0], 200)]);
        foreach ($endpoints as $accessor => $endpoint) {
            $resource = AMember::{$accessor}();
            foreach ([null, 7] as $id) {
                $result = $resource->get($id);
                $this->assertSame(['status' => 200, 'data' => ['_total' => 0]], $result);
                $url = 'https://amember.test/api/' . $endpoint . ($id === null ? '' : '/7');
                Http::assertSent(fn (Request $request) => $request->method() === 'GET'
                    && strtok($request->url(), '?') === $url
                    && $request->hasHeader('X-API-Key', 'test-key'));
            }
        }
        Http::assertSentCount(14);
    }

    public function test_new_resource_builders_do_not_share_filters(): void
    {
        Http::fake(['*' => Http::response([], 200)]);
        AMember::userGroups()->where('title', 'Admin%')->get();
        AMember::userGroups()->get();

        $requests = Http::recorded()->map(fn ($pair) => $pair[0]);
        $this->assertSame(['title' => 'Admin%'], $requests[0]['_filter']);
        $this->assertArrayNotHasKey('_filter', $requests[1]->data());
    }

    public function test_parameters_and_fluent_options_preserve_values_and_precedence(): void
    {
        Http::fake(['*' => Http::response([], 200)]);
        AMember::userNotes()->parameters(['custom' => 'first', 'zero' => 0, 'empty' => '', '_count' => 999])
            ->parameters(['custom' => 'second'])->where('user_id', 12)->where('user_id', 15)
            ->paginate(50, 2)->get(null, ['custom' => 'endpoint']);

        Http::assertSent(function (Request $request): bool {
            $query = $this->queryParameters($request);
            return $query['custom'] === 'endpoint'
                && $query['zero'] === '0' && $query['empty'] === ''
                && $query['_count'] === '50' && $query['_page'] === '2'
                && $query['_filter'] === ['user_id' => '15'];
        });
    }

    public function test_invoice_refunds_and_saved_forms_support_ids(): void
    {
        Http::fake(['*' => Http::response([], 200)]);
        AMember::invoice()->getInvoiceRefunds();
        AMember::invoice()->getInvoiceRefunds(5);
        AMember::forms()->savedForms();
        AMember::forms()->savedForms(9);

        foreach (['invoice-refunds', 'invoice-refunds/5', 'saved-forms', 'saved-forms/9'] as $path) {
            Http::assertSent(fn (Request $request) => $request->method() === 'GET'
                && strtok($request->url(), '?') === 'https://amember.test/api/' . $path);
        }
        Http::assertSentCount(4);
    }

    public function test_additional_parameters_are_available_on_existing_services(): void
    {
        Http::fake(['*' => Http::response([], 200)]);
        AMember::products()->parameters(['custom_flag' => 0])->setProducts(['title' => 'Example']);

        Http::assertSent(fn (Request $request) => $request->method() === 'POST'
            && $request['custom_flag'] === 0 && $request['title'] === 'Example');
    }
}
