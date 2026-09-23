// Hand written, not generated. `composer generate-types` walks app_path() only
// (see App\Providers\TypeScriptTransformerServiceProvider), so a model that
// crosses the Inertia boundary from vendor/ never gets a type on its own.
// Role and Permission (spatie/laravel-permission) are the two in this app:
// CampaignMembership::role(), CampaignInvitation::role() and User::roles()/
// permissions() all relate to them. App\Support\TypeScript\ModelShape refuses
// to describe a relation to any other vendor class, precisely so this file
// cannot silently go stale: add a relation to a new vendor model and
// ModelShape::VENDOR_MODELS names it, pointing back here.
//
// Shape taken from the migration in
// vendor/spatie/laravel-permission/database/migrations, with `permission.teams`
// off in config/permission.php, so neither table carries a team foreign key.
declare namespace App {
namespace Models {
export type Role = {
id: number,
name: string,
guard_name: string,
created_at: string | null,
updated_at: string | null,
};
export type Permission = {
id: number,
name: string,
guard_name: string,
created_at: string | null,
updated_at: string | null,
};
}
}
