<div class="modal" tabindex="-1" role="dialog" id="confirm_delete_modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Deletion of {{ class_basename($Model) }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this {{ class_basename($Model) }} - <strong>{{ $Model->$field_name }}</strong>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <form action="{{ $delete_url  }}" method="POST">
                    @method('delete')
                    @csrf
                    <button type="submit" class="btn btn-danger">Confirm Deletion</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>

    $(document).ready(function () {
        $('#confirm_delete_modal').modal();
    });

</script>