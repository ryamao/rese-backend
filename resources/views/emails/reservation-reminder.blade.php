{{ $reservation->user->name }} 様

本日の予約をお知らせいたします。

お店: {{ $reservation->shop->name }}
日時: {{ $reservation->reserved_at->format('Y年m月d日 H時i分') }}
人数: {{ $reservation->number_of_guests }}名
