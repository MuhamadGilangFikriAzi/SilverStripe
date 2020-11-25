<div class="admin-container">
    <input type="hidden" id="BaseHref" value="$BaseHref" />
    <div class="row">
        <div class="col-md-10">
            <div class="field dropdown">
                <select
                    name="KacabID"
                    class="dropdown has-chosen"
                    id="GroupID_select"
                    style="display: none"
                >
                    <option value="" disabled selected="">Select Group</option>
                    <% loop $Group %>
                    <option value="$ID">$Title</option>
                    <% end_loop %>
                </select>
            </div>
        </div>

        <div class="col-md-2">
            <div
                class="btn-group field CompositeField composite form-group--no-label"
            >
                <button
                    type="button"
                    value="save"
                    id="doSave"
                    data-btn-alternate-add="btn-primary font-icon-save"
                    data-btn-alternate-remove="btn-outline-primary font-icon-tick"
                    data-text-alternate="Save"
                    class="btn action btn-outline-primary"
                >
                    <span class="btn__title">Save</span>
                </button>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-bordered card-admin card">
                <div class="card-head">
                    <h3 class="panel-title">Web Access</h3>
                </div>
                <div class="card-body">
                    <div class="dd">
                        <ul class="nosymbol">
                            <% loop $KodeAkses %>
                            <li class="dd-item" data-id="1">
                                <input
                                    type="checkbox"
                                    class="checkbox-akese parent"
                                    data-parent="$KodeParent"
                                    id="val{$KodeParent}"
                                    name="$KodeParent"
                                />
                                <label for="inputChecked">$Label</label>
                                <ul class="nosymbol">
                                    <% loop $Data %>
                                    <li class="dd-item" data-id="4">
                                        <div
                                            class="checkbox-custom checkbox-primary"
                                        >
                                            <input
                                                type="checkbox"
                                                class="checkbox-akses child value-send"
                                                data-parent="{$Up.KodeParent}"
                                                id="val{$Kode}"
                                                name="{$Kode}"
                                            />
                                            <label for="inputChecked"
                                                >$Label</label
                                            >
                                        </div>
                                    </li>
                                    <% end_loop %>
                                </ul>
                            </li>
                            <% end_loop %>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
