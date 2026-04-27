<h2>Edit {{$award->name }}</h2>

<form>
    @csrf
    <label for="name">Name</label>
    <input type="text" name="name" value="{{$award->name}}">

    <input type="submit" value="Update">
</form>
