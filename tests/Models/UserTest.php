<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace Tests\Unit\Models;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class UserTest
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class UserTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateUser()
    {
        factory(User::class)->create([
            'username' => 'Abigail',
        ]);
        $this->assertDatabaseHas('users', [
            'username' => 'Abigail'
        ]);
    }
}