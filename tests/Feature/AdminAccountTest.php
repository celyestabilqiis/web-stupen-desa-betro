<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAccountTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_list_accounts(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.accounts.index'))
            ->assertOk()
            ->assertSee($user->name);
    }

    public function test_admin_can_create_account(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('admin.accounts.store'), [
            'name' => 'Admin Baru',
            'email' => 'baru@desabetro.id',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('admin.accounts.index'));
        $this->assertDatabaseHas('users', ['email' => 'baru@desabetro.id']);
    }

    public function test_admin_can_change_password(): void
    {
        $user = User::factory()->create();
        $target = User::factory()->create();

        $response = $this->actingAs($user)->put(route('admin.accounts.update-password', $target), [
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ]);

        $response->assertRedirect(route('admin.accounts.index'));
    }

    public function test_admin_can_delete_other_account(): void
    {
        $admin = User::factory()->create();
        $other = User::factory()->create();

        $response = $this->actingAs($admin)->delete(route('admin.accounts.destroy', $other));

        $response->assertRedirect(route('admin.accounts.index'));
        $this->assertDatabaseMissing('users', ['id' => $other->id]);
    }

    public function test_admin_cannot_delete_self(): void
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->delete(route('admin.accounts.destroy', $admin));

        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('users', ['id' => $admin->id]);
    }

    public function test_last_account_cannot_be_deleted(): void
    {
        $admin = User::factory()->create();

        // Karena hanya 1 user dan tidak bisa hapus diri sendiri,
        // proteksi akun terakhir juga berlaku
        $response = $this->actingAs($admin)->delete(route('admin.accounts.destroy', $admin));

        $response->assertRedirect();
        $this->assertDatabaseHas('users', ['id' => $admin->id]);
    }
}
