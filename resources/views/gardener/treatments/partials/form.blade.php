<div class="mb-3">
    <label for="disease" class="form-label">Disease</label>
    <input type="text" id="disease" name="disease" class="form-control @error('disease') is-invalid @enderror"
           value="{{ old('disease', $treatment->disease ?? '') }}" required>
    @error('disease')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="name" class="form-label">Treatment Name</label>
    <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror"
           value="{{ old('name', $treatment->name ?? '') }}" required>
    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="symptomss" class="form-label">Symptom</label>
    <textarea id="symptoms" name="symptoms" rows="3" class="form-control @error('symptoms') is-invalid @enderror" required>{{ old('symptoms', $treatment->symptoms ?? '') }}</textarea>
    @error('symptoms')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="care" class="form-label">Care Instructions</label>
    <textarea id="care" name="care" rows="3" class="form-control @error('care') is-invalid @enderror" required>{{ old('care', $treatment->care ?? '') }}</textarea>
    @error('care')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="image" class="form-label">Treatment Image</label>
    <input type="file" id="image" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
    @error('image')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    @if(!empty($treatment->image))
        <img src="{{ asset('storage/' . $treatment->image) }}" alt="Current Image" class="mt-2" style="max-width: 150px;">
    @endif
</div>
