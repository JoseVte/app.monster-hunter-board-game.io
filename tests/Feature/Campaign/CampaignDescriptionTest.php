<?php

use App\Models\User;
use App\Models\Campaign;

beforeEach(function (): void {
    $this->actingAs($this->user = User::factory()->withPersonalTeam()->create());
});

function describedAs(string $description): Campaign
{
    return Campaign::factory()->create([
        'team_id' => auth()->user()->currentTeam->id,
        'description' => $description,
    ]);
}

test('markdown is rendered to html', function (): void {
    $campaign = describedAs("**bold** and *italic*\n\n- one\n- two");

    expect($campaign->description_parsed_html)
        ->toContain('<strong>bold</strong>')
        ->toContain('<em>italic</em>')
        ->toContain('<li>one</li>');
});

test('tables survive', function (): void {
    $campaign = describedAs("| a | b |\n|---|---|\n| 1 | 2 |");

    expect($campaign->description_parsed_html)
        ->toContain('<table>')
        ->toContain('<td>1</td>');
});

test('script tags never reach the rendered html', function (): void {
    $campaign = describedAs('before <script>alert(1)</script> after');

    expect($campaign->description_parsed_html)
        ->not->toContain('<script')
        ->not->toContain('</script')
        ->toContain('before')
        ->toContain('after');
});

test('event handler attributes never reach the rendered html', function (): void {
    $campaign = describedAs('<img src=x onerror=alert(1)>');

    expect($campaign->description_parsed_html)
        ->not->toContain('onerror')
        ->not->toContain('<img');
});

test('javascript links are not rendered as links', function (): void {
    $campaign = describedAs('[click](javascript:alert(1))');

    expect($campaign->description_parsed_html)
        ->not->toContain('javascript:')
        ->toContain('click');
});

test('legacy colour markup keeps its text and loses the styling', function (): void {
    $campaign = describedAs('Texto <span style="color: #ff0000">rojo</span> normal');

    expect($campaign->description_parsed_html)
        ->toContain('Texto rojo normal')
        ->not->toContain('<span')
        ->not->toContain('color:');
});

test('the plain description strips every tag', function (): void {
    $campaign = describedAs('**bold** and <script>alert(1)</script>');

    expect($campaign->description_parsed)
        ->toContain('bold')
        ->not->toContain('<');
});

test('a campaign without a description does not blow up', function (): void {
    $campaign = Campaign::factory()->create([
        'team_id' => $this->user->currentTeam->id,
        'description' => null,
    ]);

    expect($campaign->description_parsed_html)->toEqual('')
        ->and($campaign->description_parsed)->toEqual('');
});
