<h1><?= $title; ?>  </h1>


<div class="mt-5">
<!-- session message after the update function  -->
<?php  if($this->session->flashdata('post_update')) { ?>
            <p class="alert alert-success"><?= $this->session->flashdata('post_update'); ?></p>
<?php  } ?>


  

<!-- dito lalabas yung errors   -->
<?= validation_errors(); ?> 

<!-- after clickling the submit button the process will go here  -->
<?= form_open('edit/'.$id)?>

  <div class="mb-3">
    <label for="title" class="form-label">Posts Title</label>
    <input class="form-control" name="title" id="title" type="text" placeholder="Place Title " aria-label="default input example" 
    value="<?= $title; ?>">
    <!-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> -->
  </div>

  <div class="mb-3">
  
  <label for="exampleFormControlTextarea1" class="form-label">Description </label>
  <textarea class="form-control" name="body" id="exampleFormControlTextarea1" rows="3" >

  <?= $body; ?>
  </textarea>
</div>

<input type="hidden" name="id" value="<?= $id; ?>">
  <button type="submit" class="btn btn-primary">Update</button>
</form>


</div>