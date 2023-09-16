<?php

namespace App\Livewire\App\Backend\Management;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Builder;

class UserIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    #[Url()]
    public string $search = '';

    public string $isActive = '';
    public int $perPage = 4;

    public function updating()
    {
        $this->reset();
    }

    public function updated()
    {
        $this->resetPage();
    }

    public function render()
    {
        $data = User::query()
            ->select([
                'users.id', 'users.name', 'users.username', 'users.email', 'users.profile_picture',
                'users.is_active', 'users.role_id', 'roles.name AS role_name',
            ])
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->when(auth()->user()->isSuperAdmin(), function (Builder $query) {
                $query->addSelect([
                    'users.province_id', 'users.regency_id', 'users.district_id', 'users.village_id',
                    'provinces.name AS prov_name', 'regencies.name AS regency_name',
                    'districts.name AS district_name', 'villages.name AS village_name',
                ])
                    ->leftJoin('provinces', 'users.province_id', '=', 'provinces.id')
                    ->leftJoin('regencies', 'users.regency_id', '=', 'regencies.id')
                    ->leftJoin('districts', 'users.district_id', '=', 'districts.id')
                    ->leftJoin('villages', 'users.village_id', '=', 'villages.id')
                    ->when($this->search !== '', function (Builder $query) {
                        $query->where('users.name', 'LIKE', "%{$this->search}%")
                            ->orWhere('users.email', 'LIKE', "%{$this->search}%")
                            ->orWhere(function (Builder $query) {
                                $query->where([
                                    ['provinces.name', 'LIKE', "%{$this->search}%"],
                                    ['users.regency_id', '=', null],
                                    ['users.district_id', '=', null],
                                    ['users.village_id', '=', null],
                                ]);
                            })->orWhere(function (Builder $query) {
                                $query->where([
                                    ['regencies.name', 'LIKE', "%{$this->search}%"],
                                    ['users.district_id', '=', null], ['users.village_id', '=', null],
                                ]);
                            })->orWhere(function (Builder $query) {
                                $query->where([
                                    ['districts.name', 'LIKE', "%{$this->search}%"],
                                    ['users.village_id', '=', null],
                                ]);
                            })->orWhere(function (Builder $query) {
                                $query->where('villages.name', 'LIKE', "%{$this->search}%");
                            });
                    });
            })->when(auth()->user()->isAdminProvince(), function (Builder $query) {
                $query->addSelect([
                    'users.province_id', 'users.regency_id', 'users.district_id', 'users.village_id',
                    'provinces.name AS prov_name', 'regencies.name AS regency_name',
                    'districts.name AS district_name', 'villages.name AS village_name',
                ])
                    ->join('provinces', 'users.province_id', '=', 'provinces.id')
                    ->leftJoin('regencies', 'users.regency_id', '=', 'regencies.id')
                    ->leftJoin('districts', 'users.district_id', '=', 'districts.id')
                    ->leftJoin('villages', 'users.village_id', '=', 'villages.id')
                    ->when($this->search !== '', function (Builder $query) {
                        $query->where('users.name', 'LIKE', "%{$this->search}%")
                            ->orWhere('users.email', 'LIKE', "%{$this->search}%")
                            ->orWhere(function (Builder $query) {
                                $query->where([
                                    ['provinces.name', 'LIKE', "%{$this->search}%"],
                                    ['users.regency_id', '=', null],
                                    ['users.district_id', '=', null],
                                    ['users.village_id', '=', null],
                                ]);
                            })->orWhere(function (Builder $query) {
                                $query->where([
                                    ['regencies.name', 'LIKE', "%{$this->search}%"],
                                    ['users.district_id', '=', null], ['users.village_id', '=', null],
                                ]);
                            })->orWhere(function (Builder $query) {
                                $query->where([
                                    ['districts.name', 'LIKE', "%{$this->search}%"],
                                    ['users.village_id', '=', null],
                                ]);
                            })->orWhere('villages.name', 'LIKE', "%{$this->search}%");
                    })
                    ->where('users.province_id', '=', auth()->user()->province_id);
            })->when(auth()->user()->isAdminRegency(), function (Builder $query) {
                $query->addSelect([
                    'users.regency_id', 'users.district_id', 'users.village_id',
                    'regencies.name AS regency_name', 'districts.name AS district_name', 'villages.name AS village_name',
                ])
                    ->join('regencies', 'users.regency_id', '=', 'regencies.id')
                    ->leftJoin('districts', 'users.district_id', '=', 'districts.id')
                    ->leftJoin('villages', 'users.village_id', '=', 'villages.id')
                    ->when($this->search !== '', function (Builder $query) {
                        $query->where(function (Builder $query) {
                            $query->where('users.name', 'LIKE', "%{$this->search}%")
                                ->orWhere('users.email', 'LIKE', "%{$this->search}%")
                                ->orWhere(function (Builder $query) {
                                    $query->where([
                                        ['regencies.name', 'LIKE', "%{$this->search}%"],
                                        ['users.district_id', '=', null], ['users.village_id', '=', null],
                                    ]);
                                })->orWhere(function (Builder $query) {
                                    $query->where([
                                        ['districts.name', 'LIKE', "%{$this->search}%"],
                                        ['users.village_id', '=', null],
                                    ]);
                                })->orWhere('villages.name', 'LIKE', "%{$this->search}%");
                        });
                    })
                    ->where('users.regency_id', '=', auth()->user()->regency_id);
            })->when(auth()->user()->isAdminDistrict(), function (Builder $query) {
                $query->addSelect([
                    'users.district_id', 'users.village_id',
                    'districts.name AS district_name', 'villages.name AS village_name',
                ])
                    ->join('districts', 'users.district_id', '=', 'districts.id')
                    ->leftJoin('villages', 'users.village_id', '=', 'villages.id')
                    ->when($this->search !== '', function (Builder $query) {
                        $query->where(function (Builder $query) {
                            $query->where('users.name', 'LIKE', "%{$this->search}%")
                                ->orWhere('users.email', 'LIKE', "%{$this->search}%")
                                ->orWhere(function (Builder $query) {
                                    $query->where([
                                        ['districts.name', 'LIKE', "%{$this->search}%"],
                                        ['users.village_id', '=', null],
                                    ]);
                                })->orWhere('villages.name', 'LIKE', "%{$this->search}%");
                        });
                    })
                    ->where('users.district_id', '=', auth()->user()->district_id);
            })->when(auth()->user()->isAdminVillage(), function (Builder $query) {
                $query->addSelect([
                    'users.village_id', 'villages.name AS village_name'
                ])
                    ->join('villages', 'users.village_id', '=', 'villages.id')
                    ->when($this->search !== '', function (Builder $query) {
                        $query->where(function (Builder $query) {
                            $query->where('users.name', 'LIKE', "%{$this->search}%")
                                ->orWhere('users.email', 'LIKE', "%{$this->search}%")
                                ->orWhere('villages.name', 'LIKE', "%{$this->search}%");
                        });
                    })
                    ->where('users.village_id', '=', auth()->user()->village_id);
            })->when(auth()->user()->isGuest(), function (Builder $query) {
                $query->addSelect([
                    'users.province_id', 'users.regency_id', 'users.district_id', 'users.village_id',
                ])
                    ->when($this->search !== '', function (Builder $query) {
                        $query->where(function (Builder $query) {
                            $query->where('users.name', 'LIKE', "%{$this->search}%")
                                ->orWhere('users.email', 'LIKE', "%{$this->search}%");
                        });
                    })
                    ->where([
                        ['users.id', '=', auth()->user()->id],
                        ['users.province_id', '=', null], ['users.regency_id', '=', null],
                        ['users.district_id', '=', null], ['users.village_id', '=', null],
                    ]);
            })
            ->when($this->isActive !== '', function (Builder $query) {
                $query->where('is_Active', '=', $this->isActive);
            })
            ->orderBy('users.id', 'ASC')
            ->paginate($this->perPage)->onEachSide(1);

        return view('livewire.app.backend.management.user-index', [
            'users' => $data,
        ]);
    }

    #[On('user-deleted')]
    public function destroy(?int $userId = null)
    {
        try {
            $user = User::where('id', '=', $userId)->first();

            if (!is_null($user->profile_picture)) {
                $destination = public_path('storage/images/profiles/');

                if (File::exists($destination . $user->profile_picture)) {
                    File::delete($destination . $user->profile_picture);
                }
            }

            $user->delete();

            session()->flash('message', ['text' => 'User berhasil dihapus!', 'type' => 'success']);
            $paginator = User::paginate($this->perPage);

            ($paginator->currentPage() <= $paginator->lastPage())
                ? $this->setPage($paginator->currentPage()) // still on the current page
                : $this->setPage($paginator->lastPage()); // move to last page
        } catch (\Exception $ex) {
            session()->flash('message', ['text' => 'Something goes wrong!!', 'type' => 'success']);

            return $this->redirect(route('admin.user_management.index'), true);
        }
    }
}
