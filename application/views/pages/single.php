<h1> <?= $title;  ?> </h1>

<p> <?= $body;  ?> </p>

<p> Date Added : <?= date_format($date, "F  d , Y");  ?> </p>


<!-- user restriction   -->
<?php if ($this->session->logged_in == true && $this->session->access == 1) { ?>

  <div>
    <a href="edit/<?= $id; ?>" class="btn btn-primary">Edit</a>
    <!-- <a href="delete/<?= $id; ?>" class="btn btn-danger">Delete</a> -->
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">
      Delete
    </button>
  </div>


<?php } ?>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Confirm Delete</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?= form_open('delete');  ?>
        <h3>Are you sure you want to delete this Posts ? </h3>
        <input type="text" name="id" id="" value="<?= $id; ?>" class="border border-0 fs-2">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">Delete</button>
      </div>
      <?= form_close(); ?>
    </div>
  </div>
</div>