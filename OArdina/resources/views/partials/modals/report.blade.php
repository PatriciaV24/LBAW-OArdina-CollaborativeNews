<div class="modal fade text-black"
    @if ($type == 'news' || $type == 'comment')
        id="reportContent_{{ $report_to_id }}_{{ $tab ?? '' }}" 
    @elseif ($type == 'user')
        id="reportUser_{{ $report_to_id }}" 
    @endif
    tabindex="-1"
    aria-labelledby="Report-modal-label" 
    aria-hidden="true"
>
    <iframe name="dummyframe" id="dummyframe" style="display:none"></iframe>

    <div class="modal-dialog modal-lg text-black">
        <div class="modal-content bg-light text-black">
            <div class="modal-header">
                <h5 class="modal-title text-black" id="Report-modal-label">Tipo de denúncia</h5>
                <button type="button" class="btn-close btn-close-white " data-bs-dismiss="modal"
                    aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <form enctype="multipart/form-data" target="dummyframe">
                    {{ csrf_field() }}
                    <div class="mb-3">
                        <label for="Report-{{ $report_to_id }}_{{ $tab ?? '' }}-modal-description" 
                               class="form-label">
                                Motivo
                        </label>
                        <textarea name="body" 
                                  id="Report-{{ $report_to_id }}_{{ $tab ?? '' }}-modal-description" 
                                  class="input form-control" 
                                  role="textbox" 
                                  rows="4">
                        </textarea>
                    </div>

                    <button class="btn btn-primary" data-bs-dismiss="modal"
                        onclick="report('{{ $type }}','{{ $tab ?? '' }}', {{ $report_to_id }})">Submeter</button>
                </form>
            </div>
        </div>
    </div>
</div>



<div class="position-fixed bottom-0 end-0 p-3 myToast">
    <div id="toast_{{ $report_to_id }}_{{ $tab ?? '' }}" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto"><i class="fas fa-exclamation-triangle"></i> Reportar denúncia</strong>
            <small>now</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div id="toast_{{ $report_to_id }}_{{ $tab ?? '' }}_message" class="toast-body">
        </div>
    </div>
</div>

@once
<script defer src="{{ asset('js/report.js') }}"></script>
@endonce
