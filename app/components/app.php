<h1 class="head-title">Welcome <?=(isset($_SESSION['username'])) ? $_SESSION['username'] : ''?></h1>
<div class="card add">
    <div class="txt-container">
        <form id="addTaskForm">
            <div class="form-group title">
                <label for="title">Title : </label>
                <input type="text" name="title" class="txt-input" placeholder="Title of the task" spellcheck="false" autocomplete="off" id="title" />
                <span class="error-text"></span>
            </div>
            <div class="form-group desc">
                <label for="desc">Description : </label>
                <textarea class="txt-input" placeholder="What is it about ?" name="description" id="desc"></textarea>
                <span class="error-text"></span>
            </div>
            <span class="form-error error-text"></span>
            <button class="btn btn-primary" type="submit" id="add-task" currentMode>Add Task</button>
            <button class="btn btn-primary" type="submit" id="update-task">Update Task</button>
        </form>
    </div>
</div>
<ul class="todos">
    <?php
        if(isset($dataTasks)){
            foreach ($dataTasks as $value) {
    ?>
    <li class="card">
        <div class="cb-container"><input class="cb-input" type="checkbox"><span class="check"></span></div>
        <div class="content">
            <p class="item"><?=$value['title']?></p>
            <p class="desc"><?=$value['description']?></p>
        </div>
        <a href="?cattr=<?=0?>"><button class="actions action-edit"><i class="feather icon-edit"></i></button></a>
        <button cattr="0" class="actions action-delete"><i class="feather icon-trash"></i></button>
    </li>
    <?php
            }
        }
    ?>
</ul>
<div class="card stat">
    <p class="corner"><span id="items-left">0</span> items</p>
    <div class="filter">
        <button id="all" class="on">All</button>
        <button id="active">Active</button>
        <button id="completed">Completed</button>
    </div>
    <div class="corner">
        <button id="clear-completed">Clear</button>
    </div>
</div>