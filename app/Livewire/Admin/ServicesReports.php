<?php

namespace App\Livewire\Admin;

use App\Models\Report;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

class ServicesReports extends Component
{
    public string $status = 'all';
    public string $type = '';
    public string $date = '';
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $queryString = [
        'status' => ['except' => 'all'],
        'type' => ['except' => 'all'],
        'date' => ['except' => 'all']
    ];
    public function setStatus(string $status) {
        $this->status = $status;

    }

    public function setType(string $type) {$this->type = $type;}
    public function setDate(string $date) {$this->date = (string) $date;}

    public function render()
    {
        $reports = Report::with('reporter', 'reportedUser', 'service')
        ->when($this->status !== 'all', function ($query) {
            $query->where('status', $this->status);
        })
        ->when(in_array($this->type, ['spam', 'fraud', 'inappropriate', 'duplicate', 'other']) , function($query) {
            $query->where('reason', $this->type);
        })
        ->when(in_array($this->date , ['1', '7', '30']) , function($query) {
            $query->where('created_at' , '>' , Carbon::now()->subDays((int) $this->date) );
        })
        ->orderByRaw("FIELD(status, 'pending', 'resolved', 'dismissed')")
        ->orderByDesc('created_at')
        ->paginate(10);

        return view('livewire.admin.services-reports', compact('reports'));
    }
}
