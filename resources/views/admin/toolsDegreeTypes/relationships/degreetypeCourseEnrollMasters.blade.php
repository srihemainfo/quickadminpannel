<div class="m-3">
    @can('course_enroll_master_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.course-enroll-masters.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.courseEnrollMaster.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.courseEnrollMaster.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-degreetypeCourseEnrollMasters">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>
                            <th>
                                {{ trans('cruds.courseEnrollMaster.fields.id') }}
                            </th>
                            <th>
                                {{ trans('cruds.courseEnrollMaster.fields.degreetype') }}
                            </th>
                            <th>
                                {{ trans('cruds.courseEnrollMaster.fields.academic') }}
                            </th>
                            <th>
                                {{ trans('cruds.academicYear.fields.to') }}
                            </th>
                            <th>
                                {{ trans('cruds.courseEnrollMaster.fields.batch') }}
                            </th>
                            <th>
                                {{ trans('cruds.courseEnrollMaster.fields.course') }}
                            </th>
                            <th>
                                {{ trans('cruds.courseEnrollMaster.fields.section') }}
                            </th>
                            <th>
                                {{ trans('cruds.courseEnrollMaster.fields.status_at') }}
                            </th>
                            <th>
                                {{ trans('cruds.courseEnrollMaster.fields.enroll_number') }}
                            </th>
                            <th>
                                {{ trans('cruds.courseEnrollMaster.fields.department') }}
                            </th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($courseEnrollMasters as $key => $courseEnrollMaster)
                            <tr data-entry-id="{{ $courseEnrollMaster->id }}">
                                <td>

                                </td>
                                <td>
                                    {{ $courseEnrollMaster->id ?? '' }}
                                </td>
                                <td>
                                    {{ $courseEnrollMaster->degreetype->name ?? '' }}
                                </td>
                                <td>
                                    {{ $courseEnrollMaster->academic->name ?? '' }}
                                </td>
                                <td>
                                    {{ $courseEnrollMaster->academic->to ?? '' }}
                                </td>
                                <td>
                                    {{ $courseEnrollMaster->batch->name ?? '' }}
                                </td>
                                <td>
                                    {{ $courseEnrollMaster->course->name ?? '' }}
                                </td>
                                <td>
                                    {{ $courseEnrollMaster->section->name ?? '' }}
                                </td>
                                <td>
                                    {{ $courseEnrollMaster->status_at ?? '' }}
                                </td>
                                <td>
                                    {{ $courseEnrollMaster->enroll_number ?? '' }}
                                </td>
                                <td>
                                    {{ $courseEnrollMaster->department->name ?? '' }}
                                </td>
                                <td>
                                    @can('course_enroll_master_show')
                                        <a class="btn btn-xs btn-primary" href="{{ route('admin.course-enroll-masters.show', $courseEnrollMaster->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan

                                    @can('course_enroll_master_edit')
                                        <a class="btn btn-xs btn-info" href="{{ route('admin.course-enroll-masters.edit', $courseEnrollMaster->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan

                                    @can('course_enroll_master_delete')
                                        <form action="{{ route('admin.course-enroll-masters.destroy', $courseEnrollMaster->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                        </form>
                                    @endcan

                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('course_enroll_master_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.course-enroll-masters.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 10,
  });
  let table = $('.datatable-degreetypeCourseEnrollMasters:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection