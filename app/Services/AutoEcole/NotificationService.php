<?php

namespace App\Services\AutoEcole;

use App\Models\AutoEcoleUser;
use App\Models\AutoEcoleNotification;

class NotificationService
{
    public function getNotifications(AutoEcoleUser $user, int $limit = 50): array
    {
        $notifications = AutoEcoleNotification::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();

        $nonLues = AutoEcoleNotification::where('user_id', $user->id)
            ->where('lu', false)
            ->count();

        return [
            'success' => true,
            'notifications' => $notifications,
            'non_lues' => $nonLues
        ];
    }

    public function marquerCommeLue(AutoEcoleUser $user, int $notificationId): array
    {
        $notification = AutoEcoleNotification::where('user_id', $user->id)
            ->where('id', $notificationId)
            ->first();

        if (!$notification) {
            return [
                'success' => false,
                'message' => 'Notification non trouvée'
            ];
        }

        $notification->lu = true;
        $notification->save();

        return [
            'success' => true,
            'message' => 'Notification marquée comme lue'
        ];
    }

    public function marquerToutesCommeLues(AutoEcoleUser $user): array
    {
        AutoEcoleNotification::where('user_id', $user->id)
            ->where('lu', false)
            ->update(['lu' => true]);

        return [
            'success' => true,
            'message' => 'Toutes les notifications ont été marquées comme lues'
        ];
    }

    public function supprimer(AutoEcoleUser $user, int $notificationId): array
    {
        $notification = AutoEcoleNotification::where('user_id', $user->id)
            ->where('id', $notificationId)
            ->first();

        if (!$notification) {
            return [
                'success' => false,
                'message' => 'Notification non trouvée'
            ];
        }

        $notification->delete();

        return [
            'success' => true,
            'message' => 'Notification supprimée'
        ];
    }

    public function compterNonLues(AutoEcoleUser $user): array
    {
        $count = AutoEcoleNotification::where('user_id', $user->id)
            ->where('lu', false)
            ->count();

        return [
            'success' => true,
            'non_lues' => $count
        ];
    }
}
