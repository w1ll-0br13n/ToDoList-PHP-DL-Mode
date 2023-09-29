<h1 class="head-title">Welcome <?=(isset($_SESSION['username'])) ? $_SESSION['username'] : ''?></h1>
<div class="card add">
    <div class="txt-container">
        <div id="<?=($editMode) ? 'updateTaskForm' : 'addTaskForm' ?>">
            <div class="form-group title">
                <label for="title">Title : </label>
                <input type="text" name="title" class="txt-input" value="<?=($editMode && isset($title)) ? $title : ""?>" placeholder="Title of the task" spellcheck="false" autocomplete="off" id="title" />
                <span class="error-text"></span>
            </div>
            <div class="form-group desc">
                <label for="desc">Description : </label>
                <textarea class="txt-input" placeholder="What is it about ?" name="description" id="desc"><?=($editMode && isset($description)) ? $description : ""?></textarea>
                <span class="error-text"></span>
            </div>
            <span class="form-error error-text"></span>
            <button class="btn btn-primary" id="add-task" <?=(!$editMode) ? 'currentMode' : '' ?>>Add Task</button>
            <button class="btn btn-primary" cattr="<?=($editMode && isset($idTask)) ? $idTask : ""?>" id="update-task" <?=($editMode) ? 'currentMode' : '' ?>>Update Task</button>
        </div>
    </div>
</div>
<ul class="todos">
    <?php
        if(isset($dataTasks) && !$editMode){
            $totalItems = 0;
            foreach ($dataTasks as $value) {
                $date = new DateTime($value['first_created_at']);
                if(($loadMode && $value['first_status'] == $toLoad) || (!$loadMode)){
                    $totalItems++;
    ?>
    <li class="card">
        <div class="cb-container"><input class="cb-input" type="checkbox" cattr="<?=$value['first_id']?>" <?=($value['first_status'] != 0) ? "checked" : ""?> onclick="toogleCheck(this)"><span class="check"></span></div>
        <div class="content">
            <p class="item"><?=$value['first_title']?></p>
            <p class="desc"><?=$value['first_description']?></p>
            <p class="small">Created • <?=$date->format('d M Y')?> • </p>
        </div>
        <a href="?cattr=<?=$value['first_id']?>"><button class="actions action-edit"><i class="feather icon-edit"></i></button></a>
        <button cattr="<?=$value['first_id']?>" class="actions action-delete delete-task"><i class="feather icon-trash"></i></button>
    </li>
    <?php
                }
            }
        }
    ?>
</ul>
<div class="card stat">
    <p class="corner"><span id="items-left"><?=(isset($totalItems)) ? $totalItems : '0'?></span> items</p>
    <div class="filter">
        <a href="<?=$config['Home']?>"><button id="all" <?=(!$loadMode) ? 'class="on"' : ''?>>All</button></a>
        <a href="?l=202"><button id="active" <?=($loadMode && (int)$mode == 202) ? 'class="on"' : ''?>>Active</button></a>
        <a href="?l=408"><button id="completed" <?=($loadMode && (int)$mode == 408) ? 'class="on"' : ''?>>Completed</button></a>
    </div>
    <div class="corner">
        <a href="?reset=200"><button id="clear-completed">Clear</button></a>
    </div>
</div>