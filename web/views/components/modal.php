<div class="modal" id="modal-success" tabindex="-1" role="dialog" data-overlay-dismissal-disabled="true" data-esc-dismissal-disabled="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <h5 class="modal-title">Success Update Profile</h5>
            <div class="text-right mt-20">
                <a class="btn btn-primary" href="profile.php?ref=settings">OK</a>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="modal-error" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content bg-danger">
            <h5 class="modal-title">Error Wrong Password</h5>
            <div class="text-right mt-20">
                <a href="#" class="btn mr-5" role="button">Close</a>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="modal-profile" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content ">
            <h5 class="modal-title">Update Images</h5>
            <canvas style="touch-action: none; cursor: move;" id="photo_canvas"></canvas>
            <input type="range" min="1" max="5" value="1" step="0.01" id="photo_range" style="display: none;" />
            <input type="file" id="photo" name="photo" accept=".jpg,.png,.gif,.jpeg" />
            <div class="text-right mt-20">
                <button type="button" onclick="apply_photo();" data-dismiss="modal" class="btn">Apply photo</button>
                <button class="btn" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
