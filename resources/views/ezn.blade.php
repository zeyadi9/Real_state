@extends('layout')
@section('title', 'Permission Request')
@section('content')

@if($errors->any())
    @foreach($errors->all() as $error)
        <div class="alert alert-danger">{{ $error }}</div>
    @endforeach
@endif

<form class="max-w-md mx-auto mt-40" action="{{ route('permission_post') }}" method="POST">
    @csrf
    <div class="grid md:grid-cols-2 md:gap-6">
        <div class="mb-3">
            <label for="date" class="block mb-2.5 text-sm font-medium text-heading">التاريخ</label>
            <input type="date" name="date" id="date" min="{{ $dateBounds['min'] }}" max="{{ $dateBounds['max'] }}" value="{{ old('date', $dateBounds['max']) }}" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs" required />
            <p class="mt-1 text-xs text-body">Allowed dates: today or yesterday only.</p>
        </div>
        <div class="mb-3">
            <label for="day" class="block mb-2.5 text-sm font-medium text-heading">اليوم</label>
            <input type="text" name="day" id="day" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs" required />
        </div>
    </div>

    @if(Auth::user()->email === 'guest@gamma.com')
        <div class="mb-3 mt-4">
            <label for="name" class="block mb-2.5 text-sm font-medium text-heading">الاسم</label>
            <input type="text" name="name" id="name" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs" required />
        </div>
    @else
        <input type="hidden" name="name" value="{{ Auth::user()->name }}" />
        <div hidden class="mb-3 mt-4">
            <label class="block mb-2.5 text-sm font-medium text-heading">الاسم</label>
            <input type="text" value="{{ Auth::user()->name }}" disabled class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base block w-full px-3 py-2.5 shadow-xs opacity-70" />
        </div>
    @endif

    <div class="mb-3">
        <label for="permission_type" class="block mb-2.5 text-sm font-medium text-heading">نوع الاذن</label>
        <select name="permission_type" id="permission_type" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs" required>
            <option value="إذن تأخير">إذن تأخير</option>
            <option value="إذن انصراف باكر">إذن انصراف باكر</option>
            <option value="إذن نسيان بصمة حضور">إذن نسيان بصمة حضور</option>
            <option value="إذن نسيان بصمة انصراف">إذن نسيان بصمة انصراف</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="reason" class="block mb-2.5 text-sm font-medium text-heading">السبب</label>
        <input type="text" name="reason" id="reason" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs" required />
    </div>

<div id="timeFieldsSection" class="grid grid-cols-2 gap-3">
    <div class="mb-3">
        <label for="from" class="block mb-2 text-sm font-medium text-heading">من</label>
        <input
            type="text"
            name="from"
            id="from"
            class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-2 py-2 shadow-xs placeholder:text-body"
            placeholder="00:00 AM"
        />
    </div>

    <div class="mb-3">
        <label for="to" class="block mb-2 text-sm font-medium text-heading">الى</label>
        <input
            type="text"
            name="to"
            id="to"
            class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-2 py-2 shadow-xs placeholder:text-body"
            placeholder="00:00 PM"
        />
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const config = {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            altInput: true,
            altFormat: "h:i K",
            time_24hr: false,
            locale: {
                amPM: ["ص", "م"]
            }
        };
        flatpickr("#from", config);
        flatpickr("#to", config);

        const typeSelect = document.getElementById('permission_type');
        const timeFields = document.getElementById('timeFieldsSection');

        function toggleTimeFields() {
            const val = typeSelect.value;
            if (val === 'إذن نسيان بصمة حضور' || val === 'إذن نسيان بصمة انصراف') {
                timeFields.classList.add('hidden');
                // Clear values when hidden to avoid confusion
                if (document.querySelector('#from')._flatpickr) document.querySelector('#from')._flatpickr.clear();
                if (document.querySelector('#to')._flatpickr) document.querySelector('#to')._flatpickr.clear();
            } else {
                timeFields.classList.remove('hidden');
            }
        }

        typeSelect.addEventListener('change', toggleTimeFields);
        toggleTimeFields(); // Initial state
    });
</script>

<button type="submit" class="text-white bg-gradient-to-l from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 focus:ring-4 focus:ring-blue-300 font-semibold rounded-xl text-sm px-5 py-2.5 shadow-md transition-all duration-200 border border-black">
    Submit
</button>

</form>


@endsection
