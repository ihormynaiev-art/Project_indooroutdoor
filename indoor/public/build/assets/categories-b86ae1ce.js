if($.fn.dataTable.isDataTable("#categories-data"))n=$("#categories-data").DataTable();else var n=$("#categories-data").DataTable({ordering:!0,ajax:"categories",columnDefs:[{width:"20%",targets:0}],columns:[{data:null,render:function(e,a,i){if(a==="sort"||a==="type")return e.image_path?1:0;let t=e.image_path?"/storage/"+e.image_path:"/assets/img/not-found.jpg";return`
                        <div class="table-imgname">
                            <a href="/admin/categories/${e.id}/edit">
                                <img src="${t}" class="me-2" alt="img">
                            </a>
                        </div>`}},{data:"name",name:"name"},{data:"slug",name:"slug"},{data:"parent_id",name:"parent",render:function(e,a,i){return i.parent?i.parent.name:"-"}},{data:"prio",name:"priority"},{data:"is_active",name:"active",render:function(e,a,i){if(a==="sort"||a==="type")return e?1:0;var t=e?"checked":"",s=`
                        <div class="mx-2 active-switch">
                            <label class="switch">
                                <input name="is_active" id="is_active" value="1" ${t} data-id=${i.id} type="checkbox">
                                <span class="sliders round"></span>
                            </label>
                        </div>`;return s}},{data:"show_in_home_top_slider",name:"show_in_home_top_slider",render:function(e,a,i){if(a==="sort"||a==="type")return e?1:0;var t=e?"checked":"",s=`
                        <div class="mx-2 active-switch">
                            <label class="switch">
                                <input name="show_in_home_top_slider" id="show_in_home_top_slider" value="1" ${t} data-id=${i.id} type="checkbox">
                                <span class="sliders round"></span>
                            </label>
                        </div>`;return s}},{data:"id",orderable:!1,render:function(e,a,i){var t=`
                    <div class="action-language">
                        <a class="table-edit" href="/admin/categories/${e}/edit">
                            <i class="fa-regular fa-pen-to-square"></i><span>Edit</span>
                        </a>
                        <a class="table-delete" href="javascript:void(0);" data-id="${e}">
                            <i class="fa-solid fa-trash-can"></i><span>Delete</span>
                        </a>
                    </div>`;return t}}],paging:!0,searching:!0,info:!0,dom:"rtip",language:{paginate:{first:"",last:"",next:"",previous:""},info:"Showing _START_ - _END_ of _TOTAL_ items",infoFiltered:"",infoEmpty:""}});$(document).on("click",".table-resposnive .table-delete",function(){var e=$(this).data("id");Swal.fire({title:"Delete Category",text:"Are you sure want to delete? All its subcategories will be deleted",showCancelButton:!0,focusConfirm:!1,confirmButtonText:"delete",cancelButtonText:"close",customClass:{confirmButton:"btn btn-primary mr-3",cancelButton:"btn btn-secondary"},showClass:{popup:"swal2-noanimation",backdrop:"swal2-noanimation"},buttonsStyling:!1}).then(a=>{a.isConfirmed&&$.ajax({type:"DELETE",url:"/admin/categories/"+e+"/",data:{_method:"DELETE",_token:$("#token").val()},success:function(i){i.status==="success"&&n.ajax.reload()}})})});$("#search").on("keyup",function(){n.search(this.value).draw()});$(document).on("change",".table-resposnive input[name=is_active]",function(){var e=$(this).data("id"),a=$(this).val(),i=this.id;i==="is_active"&&(a=$(this).prop("checked"));var t={};t._method="PATCH",t._token=$("#token").val(),t[i]=a,$.ajax({type:"PATCH",url:"/admin/categories/"+e+"/updateIsActive",data:t,success:function(s){s.status==="success"&&console.log(s.status)}})});$(document).on("change",".table-resposnive input[name=show_in_home_top_slider]",function(){var e=$(this).data("id"),a=$(this).val(),i=this.id;i==="show_in_home_top_slider"&&(a=$(this).prop("checked"));var t={};t._method="PATCH",t._token=$("#token").val(),t[i]=a,$.ajax({type:"PATCH",url:"/admin/categories/"+e+"/updateShowInHomeTopSlider",data:t,success:function(s){s.status==="success"&&console.log(s.status)}})});
