<?php

namespace Componist\Core\Models;

use App\Models\User;
use Componist\Core\Notifications\ComponistCoreNotification\MessageNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Notification;

/**
 * @property int $id
 * @property int $user_id
 * @property int $read
 * @property Carbon|null $read_at
 * @property string|null $title
 * @property string|null $message
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 */
class ComponistCoreNotification extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'title',
        'message',
    ];

    public static function CreateMessage(int|string $val, string $title, string $message): ?self
    {
        $userId = null;

        if (is_int($val)) {
            if ($user = User::where('id', $val)->first()) {
                $userId = $user['id'];
            }
        }

        if (is_string($val)) {
            if ($user = User::where('email', $val)->first()) {

                if ($user['id']) {
                    $userId = $user['id'];
                }
            }
        }

        if (is_int($userId)) {
            $result = self::create([
                'user_id' => $userId,
                'title' => trim($title),
                'message' => trim($message),
                'created_at' => date('Y-m-d H:i:s'),
            ]);

            if ($user) {
                Notification::send($user, new MessageNotification);
            }

            return $result;
        }

        return null;
    }
}
