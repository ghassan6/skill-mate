<x-layout>
    <x-slot:title>Coas</x-slot:title>
    <x-user-sidebar>
    <h1>Your Conversations</h1>
<ul class="list-group">
@foreach($conversations as $conv)
  @php
    $other = Auth::id() === $conv->user_one_id ? $conv->userTwo : $conv->userOne;
    $last  = $conv->messages->first()->message ?? 'No messages yet.';
  @endphp
  <li class="list-group-item">
    <a href="{{ route('conversations.show', $conv) }}">
      <strong>{{ $other->username }}</strong><br>
      <small>{{ Str::limit($last, 50) }}</small>
    </a>
  </li>
@endforeach
</ul>
</x-user-sidebar>
</x-layout>