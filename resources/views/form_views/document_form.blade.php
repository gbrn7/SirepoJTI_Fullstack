<div class="mb-2">
  <label class="form-label">Title</label>
  <input type="text" class="form-control" placeholder="Enter your title"
    value="{{old('title', isset($document) ? $document->title : '')}}" name="title" required />
</div>
<div class="mb-2">
  <label class="form-label">Abstract</label>
  <textarea class="form-control" rows="3" placeholder="Enter document abstract" required
    name="abstract">{{old('abstract', isset($document) ? $document->abstract : '')}}</textarea>
</div>
<div class="mb-2">
  <label class="form-label">Category</label>
  <select class="form-select" aria-label="Default select example" name="category" required>
    <option value="">Select document category</option>
    @foreach ($categories as $category)
    <option value="{{$category->id}}" @selected(old('category', isset($document) ? $document->id_category :
      '') ==$category->id)>
      {{$category->category}}
    </option>
    @endforeach
  </select>
</div>
<div class="mb-2">
  <label for="formFile" class="form-label">Document PDF</label>
  <input class="form-control" type="file" id="formFile" name="file" />
</div>
<div class="wrapper d-flex justify-content-end">
  <button class="btn btn-submit text-white px-5 btn-warning" type="submit">Submit</button>
</div>