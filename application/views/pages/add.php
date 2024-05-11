<h1><?= $title; ?>  </h1>


<div class="mt-5">

<!-- dito lalabas yung errors   -->
<!-- <? //= validation_errors(); ?> -->

<!-- after clickling the submit button the process will go here  -->
<?= form_open('add', 'enctype="multipart/form-data"')?>
 
  <div class="mb-3">
    <label for="title" class="form-label">Posts Title</label>
    <input class="form-control" name="title" id="title" type="text" placeholder="Place Title " aria-label="default input example" 
    value="<?= set_value('title'); ?>">
    
    <!-- error message  -->
    <?= form_error('title') ; ?>
  </div>

  <div class="mb-3">
    
  <label for="exampleFormControlTextarea1" class="form-label">Description </label>
  <textarea class="form-control" name="body" id="exampleFormControlTextarea1" rows="3" >
  
  <?= set_value('body'); ?>
  </textarea>
  <!-- error message  -->
  <?= form_error('body') ; ?>

  <label for="Image" class="form-label" >Image</label>
  <input type="file" name="post_image" id="Image" class="form-control">
  <!-- error message  -->
  <?php if($img_error){echo $img_error;  }?>
</div>
  <button type="submit" class="btn btn-primary">Submit</button>
  <?= form_close(); ?>


</div>