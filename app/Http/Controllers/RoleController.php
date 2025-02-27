<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    public function index() {
        $role = Role::all();

        return view('dashboard.pengaturan.akun-role.index', [
            'role' => $role
        ]);
    }

    public function create() {
        return view('dashboard.pengaturan.akun-role.create');
    }

    public function edit(Request $request,$id) {
        $roleId = Crypt::decrypt($id);

        $role = Role::findOrFail($roleId);

        return view('dashboard.pengaturan.akun-role.edit', [
            'role' => $role
        ]);
    }

    public function store(Request $request) {

        $request->validate([
            'role_name' => 'required',
        ]);
        
        DB::beginTransaction();
        try {

            $permission = new Permission();

            if ($request->lt_menu) {
                $permission->daftar_tiket = true;
                if ($request->lt_option) {
                    $permission->daftar_tiket_option = json_encode($request->lt_option) ;
                }
            }
            if ($request->pm_menu) {
                $permission->penanganan_masalah = true;
                if ($request->pm_option) {
                    $permission->penanganan_masalah_option = json_encode($request->pm_option) ;
                }
            }
            if ($request->pa_menu) {
                $permission->pengajuan_aset = true;
                if ($request->pa_option) {
                    $permission->pengajuan_aset_option = json_encode($request->pa_option) ;
                }
            }
            if ($request->mnb_menu) {
                $permission->menu_bom = true;
                if ($request->mnb_option) {
                    $permission->menu_bom_option = json_encode($request->mnb_option) ;
                }
            }
            if ($request->pp_menu) {
                $permission->program_promo = true;
                if ($request->pp_option) {
                    $permission->program_promo_option = json_encode($request->pp_option) ;
                }
            }
            if ($request->dsc_menu) {
                $permission->diskon = true;
                if ($request->dsc_option) {
                    $permission->diskon_option = json_encode($request->dsc_option) ;
                }
            }
            if ($request->sh_menu) {
                $permission->selisih_harga = true;
                if ($request->sh_option) {
                    $permission->selisih_harga_option = json_encode($request->sh_option) ;
                }
            }
            if ($request->void_menu) {
                $permission->void = true;
                if ($request->void_option) {
                    $permission->void_option = json_encode($request->void_option) ;
                }
            }
            if ($request->lo_menu) {
                $permission->list_outlet = true;
                if ($request->lo_option) {
                    $permission->list_outlet_option = json_encode($request->lo_option) ;
                }
            }
            if ($request->coa_menu) {
                $permission->coa = true;
                if ($request->coa_option) {
                    $permission->coa_option = json_encode($request->coa_option) ;
                }
            }
            if ($request->prd_menu) {
                $permission->product = true;
                if ($request->prd_option) {
                    $permission->product_option = json_encode($request->prd_option) ;
                }
            }
            if ($request->sup_menu) {
                $permission->supplier = true;
                if ($request->sup_option) {
                    $permission->supplier_option = json_encode($request->sup_option) ;
                }
            }
            if ($request->bu_menu) {
                $permission->bisnis_unit = true;
                if ($request->bu_option) {
                    $permission->bisnis_unit_option = json_encode($request->bu_option) ;
                }
            }
            if ($request->dvs_menu) {
                $permission->divisi = true;
                if ($request->dvs_option) {
                    $permission->divisi_option = json_encode($request->dvs_option) ;
                }
            }
            if ($request->kry_menu) {
                $permission->karyawan = true;
                if ($request->kry_option) {
                    $permission->karyawan_option = json_encode($request->kry_option) ;
                }
            }
            if ($request->slm_menu) {
                $permission->mode_penjualan = true;
                if ($request->slm_option) {
                    $permission->mode_penjualan_option = json_encode($request->slm_option) ;
                }
            }
            if ($request->bco_menu) {
                $permission->backoffice = true;
                if ($request->bco_option) {
                    $permission->backoffice_option = json_encode($request->bco_option) ;
                }
            }
            if ($request->asset_menu) {
                $permission->aset = true;
                if ($request->asset_option) {
                    $permission->aset_option = json_encode($request->asset_option) ;
                }
            }
            if ($request->tkt_menu) {
                $permission->ticket_kategori = true;
                if ($request->tkt_option) {
                    $permission->ticket_kategori_option = json_encode($request->tkt_option) ;
                }
            }
            if ($request->akt_menu) {
                $permission->aset_kategori = true;
                if ($request->akt_option) {
                    $permission->aset_kategori_option = json_encode($request->akt_option) ;
                }
            }
            if ($request->arl_menu) {
                $permission->akun_role = true;
                if ($request->arl_option) {
                    $permission->akun_role_option = json_encode($request->arl_option) ;
                }
            }
            if ($request->lak_menu) {
                $permission->list_akun = true;
                if ($request->lak_option) {
                    $permission->list_akun_option = json_encode($request->lak_option) ;
                }
            }
            if ($request->faq_menu) {
                $permission->faq = true;
                if ($request->faq_option) {
                    $permission->faq_option = json_encode($request->faq_option) ;
                }
            }
            if ($request->articles_menu) {
                $permission->articles = true;
                if ($request->articles_option) {
                    $permission->articles_option = json_encode($request->articles_option) ;
                }
            }

            $permission->save();

            $role = new Role;
            $role->name_role = $request->role_name;
            $role->permission_id = $permission->id;
            $role->save();
            

            DB::commit();
            
            return redirect(route('akun-role'))->with('success', 'Role baru berhasil dibuat');
        } catch (\Exception $e) {
            
            DB::rollBack();
            
            return back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, $id) {
        
        $permissionId = Crypt::decrypt($id);

        // return $request->all();

        DB::beginTransaction();

        try {

            $permission = Permission::findOrFail($permissionId);

            $permission->daftar_tiket = false;
            $permission->daftar_tiket_option = "[]" ;
            $permission->penanganan_masalah = false;
            $permission->penanganan_masalah_option = "[]" ;
            $permission->pengajuan_aset = false;
            $permission->pengajuan_aset_option = "[]" ;
            $permission->menu_bom = false;
            $permission->menu_bom_option = "[]" ;
            $permission->program_promo = false;
            $permission->program_promo_option = "[]" ;
            $permission->diskon = false;
            $permission->diskon_option = "[]" ;
            $permission->selisih_harga = false;
            $permission->selisih_harga_option = "[]" ;
            $permission->void = false;
            $permission->void_option = "[]" ;
            $permission->list_outlet = false;
            $permission->list_outlet_option = "[]" ;
            $permission->coa = false;
            $permission->coa_option = "[]" ;
            $permission->product = false;
            $permission->product_option = "[]" ;
            $permission->supplier = false;
            $permission->supplier_option = "[]" ;
            $permission->bisnis_unit = false;
            $permission->bisnis_unit_option = "[]" ;
            $permission->divisi = false;
            $permission->divisi_option = "[]" ;
            $permission->karyawan = false;
            $permission->karyawan_option = "[]" ;
            $permission->mode_penjualan = false;
            $permission->mode_penjualan_option = "[]" ;
            $permission->backoffice = false;
            $permission->backoffice_option = "[]" ;
            $permission->aset = false;
            $permission->aset_option = "[]" ;
            $permission->ticket_kategori = false;
            $permission->ticket_kategori_option = "[]" ;
            $permission->aset_kategori = false;
            $permission->aset_kategori_option = "[]" ;
            $permission->akun_role = false;
            $permission->akun_role_option = "[]" ;
            $permission->list_akun = false;
            $permission->list_akun_option = "[]" ;
            $permission->faq = false;
            $permission->faq_option = "[]" ;
            $permission->articles = false;
            $permission->articles_option = "[]" ;

            if ($request->lt_menu) {
                $permission->daftar_tiket = true;
                if ($request->lt_option) {
                    $permission->daftar_tiket_option = json_encode($request->lt_option) ;
                }
            }
            if ($request->pm_menu) {
                $permission->penanganan_masalah = true;
                if ($request->pm_option) {
                    $permission->penanganan_masalah_option = json_encode($request->pm_option) ;
                }
            }
            if ($request->pa_menu) {
                $permission->pengajuan_aset = true;
                if ($request->pa_option) {
                    $permission->pengajuan_aset_option = json_encode($request->pa_option) ;
                }
            }
            if ($request->mnb_menu) {
                $permission->menu_bom = true;
                if ($request->mnb_option) {
                    $permission->menu_bom_option = json_encode($request->mnb_option) ;
                }
            }
            if ($request->pp_menu) {
                $permission->program_promo = true;
                if ($request->pp_option) {
                    $permission->program_promo_option = json_encode($request->pp_option) ;
                }
            }
            if ($request->dsc_menu) {
                $permission->diskon = true;
                if ($request->dsc_option) {
                    $permission->diskon_option = json_encode($request->dsc_option) ;
                }
            }
            if ($request->sh_menu) {
                $permission->selisih_harga = true;
                if ($request->sh_option) {
                    $permission->selisih_harga_option = json_encode($request->sh_option) ;
                }
            }
            if ($request->void_menu) {
                $permission->void = true;
                if ($request->void_option) {
                    $permission->void_option = json_encode($request->void_option) ;
                }
            }
            if ($request->lo_menu) {
                $permission->list_outlet = true;
                if ($request->lo_option) {
                    $permission->list_outlet_option = json_encode($request->lo_option) ;
                }
            }
            if ($request->coa_menu) {
                $permission->coa = true;
                if ($request->coa_option) {
                    $permission->coa_option = json_encode($request->coa_option) ;
                }
            }
            if ($request->prd_menu) {
                $permission->product = true;
                if ($request->prd_option) {
                    $permission->product_option = json_encode($request->prd_option) ;
                }
            }
            if ($request->sup_menu) {
                $permission->supplier = true;
                if ($request->sup_option) {
                    $permission->supplier_option = json_encode($request->sup_option) ;
                }
            }
            if ($request->bu_menu) {
                $permission->bisnis_unit = true;
                if ($request->bu_option) {
                    $permission->bisnis_unit_option = json_encode($request->bu_option) ;
                }
            }
            if ($request->dvs_menu) {
                $permission->divisi = true;
                if ($request->dvs_option) {
                    $permission->divisi_option = json_encode($request->dvs_option) ;
                }
            }
            if ($request->kry_menu) {
                $permission->karyawan = true;
                if ($request->kry_option) {
                    $permission->karyawan_option = json_encode($request->kry_option) ;
                }
            }
            if ($request->slm_menu) {
                $permission->mode_penjualan = true;
                if ($request->slm_option) {
                    $permission->mode_penjualan_option = json_encode($request->slm_option) ;
                }
            }
            if ($request->bco_menu) {
                $permission->backoffice = true;
                if ($request->bco_option) {
                    $permission->backoffice_option = json_encode($request->bco_option) ;
                }
            }
            if ($request->asset_menu) {
                $permission->aset = true;
                if ($request->asset_option) {
                    $permission->aset_option = json_encode($request->asset_option) ;
                }
            }
            if ($request->tkt_menu) {
                $permission->ticket_kategori = true;
                if ($request->tkt_option) {
                    $permission->ticket_kategori_option = json_encode($request->tkt_option) ;
                }
            }
            if ($request->akt_menu) {
                $permission->aset_kategori = true;
                if ($request->akt_option) {
                    $permission->aset_kategori_option = json_encode($request->akt_option) ;
                }
            }
            if ($request->arl_menu) {
                $permission->akun_role = true;
                if ($request->arl_option) {
                    $permission->akun_role_option = json_encode($request->arl_option) ;
                }
            }
            if ($request->lak_menu) {
                $permission->list_akun = true;
                if ($request->lak_option) {
                    $permission->list_akun_option = json_encode($request->lak_option) ;
                }
            }
            if ($request->faq_menu) {
                $permission->faq = true;
                if ($request->faq_option) {
                    $permission->faq_option = json_encode($request->faq_option) ;
                }
            }
            if ($request->articles_menu) {
                $permission->articles = true;
                if ($request->articles_option) {
                    $permission->articles_option = json_encode($request->articles_option) ;
                }
            }

            // dd($request->all());

            $permission->update();

            $role = Role::where('permission_id', $permissionId)->first();
            $role->name_role = $request->role_name;
            $role->update();
            

            DB::commit();
            
            return back()->with('success', 'Permission berhasil diubah');
        } catch (\Exception $e) {
            
            DB::rollBack();
            
            return back()->with('error', "Terjadi kesalahan saat memperbarui permission.");
        }
    }
}
