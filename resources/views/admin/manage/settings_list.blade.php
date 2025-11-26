<div class="card shadow-sm mt-4">
    <div class="card-header bg-light fw-bold">Existing Schemes</div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-sm table-fixed mb-0 align-middle">
                <thead class="bg-white">
                    <tr>
                        <th>Sr.N</th>
                        <th>Scheme Name</th>
                        <th>Scheme Plan</th>
                        <th>User Group</th>
                        <th>EMI Amt</th>
                        <th>No. Users</th>
                        <th>No. EMI</th>
                        <th>Bonus</th>
                        <th>Start Token</th>
                        <th>End Token</th>
                      <th>Start Date</th>

                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($settings as $i => $s)
                        <tr>
                            <td>{{ $settings->firstItem() + $i }}</td>
<td>{{ $s->scheme->name ?? '—' }}</td>
                            <td>{{ $s->scheme_plan }}</td>
                            <td>{{ $s->user_group }}</td>
                            <td>{{ $s->emi_amt }}</td>
                            <td>{{ $s->no_of_users }}</td>
                            <td>{{ $s->no_of_emi }}</td>
                            <td>{{ $s->bonus_amount }}</td>
                            <td>{{ $s->start_token_no }}</td>
                            <td>{{ $s->end_token_no }}</td>
                           
<td>{{$s->created_at}}</td>
                           <td class="text-center">

    <div class="d-flex justify-content-center align-items-center gap-2">

        <!-- Edit -->
        <a href="{{ route('admin.manage.settings.edit', $s->id) }}"
           class="btn btn-sm btn-warning"
           title="Edit">
            <i class="bi bi-pencil-square"></i>
        </a>





        <!-- Delete -->
        <form action="{{ route('admin.manage.settings.destroy', $s->id) }}"
              method="POST"
              class="d-inline delete-form">
            @csrf
            @method('DELETE')

            <button type="button"
                    class="btn btn-sm btn-danger delete-btn"
                    title="Delete">
                <i class="bi bi-trash"></i>
            </button>
        </form>

    </div>

</td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center p-3 text-muted">
                                No scheme settings found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="p-2">
            {{ $settings->links() }}
        </div>
    </div>
</div>

{{-- Delete confirmation --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            let form = this.closest('form');

            Swal.fire({
                title: 'Delete this scheme?',
                text: 'This action cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete',
                cancelButtonText: 'Cancel'
            }).then(res => {
                if (res.isConfirmed) form.submit();
            });
        });
    });
});
</script>
