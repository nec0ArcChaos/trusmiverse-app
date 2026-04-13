<div class="container-fluid mb-4">
    <div class="row align-items-center page-title">
        <div class="col-12 col-md mb-2 mb-sm-0">
            <h5 class="mb-0">Alerts</h5>
        </div>
    </div>
    <div class="row">
        <nav aria-label="breadcrumb" class="breadcrumb-theme">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Components</li>
                <li class="breadcrumb-item active" aria-current="page">Alerts</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-xl-9">
            <div class="row">
                <div class="col-12 mb-4">
                    <div id="section-1" class="ui-card">
                        <div class="alert alert-warning" role="alert">
                            <h4 class="alert-heading">Dismissable Alerts!</h4>
                            <p class="text-muted mb-15">
                                Add a dismiss button and the <code>.alert-dismissible</code> class, which adds extra
                                padding to the right of the alert and positions the <code>.btn-close</code> button,
                                alternatively for a white close button add <code>.btn-close .btn-close-white</code>
                                text.
                            </p>
                        </div>
                        <ul class="nav nav-tabs nav-WinDOORS mb-4" id="navtabscard3" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab1-preview"
                                    type="button" role="tab" aria-controls="tab13" aria-selected="true"> <i
                                        class="bi-eye fs-16 mr-5 va-middle"></i> Preview</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab1-code" type="button"
                                    role="tab" aria-controls="tab1-code" aria-selected="false" tabindex="-1"><i
                                        class="bi-code-slash fs-16 mr-5 va-middle"></i> Code</button>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active show" id="tab1-preview" role="tabpanel">
                                <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                    <strong>Primary - </strong> A simple primary alert—check it out!
                                </div><!-- / alert-dismissable -->

                                <div class="alert alert-secondary alert-dismissible fade show" role="alert">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                    <strong>Secondary - </strong> A simple secondary alert—check it out!
                                </div><!-- / alert-dismissable -->

                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                    <strong>Success - </strong> A simple success alert—check it out!
                                </div><!-- / alert-dismissable -->

                                <div class="alert alert-info alert-dismissible fade show" role="alert">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                    <strong>Info - </strong> A simple info alert—check it out!
                                </div><!-- / alert-dismissable -->

                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                    <strong>Warning - </strong> A simple warning alert—check it out!
                                </div><!-- / alert-dismissable -->

                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                    <strong>Primary - </strong> A simple danger alert—check it out!
                                </div><!-- / alert-dismissable -->
                            </div><!-- / preview-->

                            <div class="tab-pane" id="tab1-code" role="tabpanel">
                                <div class="preview-code">
                                    <pre
                                        class=" language-markup"><button class="btn btn-copy" data-clipboard-action="copy" data-clipboard-target="#code-1"><i class="bi-save mr-5"></i> Copy</button><code id="code-1" class=" language-markup" style=""><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>alert alert-primary alert-dismissible fade show<span class="token punctuation">"</span></span> <span class="token attr-name">role</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>alert<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>
    <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>button</span> <span class="token attr-name">type</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>button<span class="token punctuation">"</span></span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>btn-close<span class="token punctuation">"</span></span> <span class="token attr-name">data-bs-dismiss</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>alert<span class="token punctuation">"</span></span> <span class="token attr-name">aria-label</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>Close<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>button</span><span class="token punctuation">&gt;</span></span>
    <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>strong</span><span class="token punctuation">&gt;</span></span>Primary - <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>strong</span><span class="token punctuation">&gt;</span></span> A simple primary alert—check it out!
<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span><span class="token comment" spellcheck="true">&lt;!-- / alert-dismissable --&gt;</span>

<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>alert alert-secondary alert-dismissible fade show<span class="token punctuation">"</span></span> <span class="token attr-name">role</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>alert<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>
    <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>button</span> <span class="token attr-name">type</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>button<span class="token punctuation">"</span></span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>btn-close<span class="token punctuation">"</span></span> <span class="token attr-name">data-bs-dismiss</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>alert<span class="token punctuation">"</span></span> <span class="token attr-name">aria-label</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>Close<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>button</span><span class="token punctuation">&gt;</span></span>
    <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>strong</span><span class="token punctuation">&gt;</span></span>Secondary - <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>strong</span><span class="token punctuation">&gt;</span></span> A simple secondary alert—check it out!
<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span><span class="token comment" spellcheck="true">&lt;!-- / alert-dismissable --&gt;</span>

<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>alert alert-success alert-dismissible fade show<span class="token punctuation">"</span></span> <span class="token attr-name">role</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>alert<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>
    <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>button</span> <span class="token attr-name">type</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>button<span class="token punctuation">"</span></span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>btn-close<span class="token punctuation">"</span></span> <span class="token attr-name">data-bs-dismiss</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>alert<span class="token punctuation">"</span></span> <span class="token attr-name">aria-label</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>Close<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>button</span><span class="token punctuation">&gt;</span></span>
    <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>strong</span><span class="token punctuation">&gt;</span></span>Success - <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>strong</span><span class="token punctuation">&gt;</span></span> A simple success alert—check it out!
<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span><span class="token comment" spellcheck="true">&lt;!-- / alert-dismissable --&gt;</span>

<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>alert alert-info alert-dismissible fade show<span class="token punctuation">"</span></span> <span class="token attr-name">role</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>alert<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>
    <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>button</span> <span class="token attr-name">type</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>button<span class="token punctuation">"</span></span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>btn-close<span class="token punctuation">"</span></span> <span class="token attr-name">data-bs-dismiss</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>alert<span class="token punctuation">"</span></span> <span class="token attr-name">aria-label</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>Close<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>button</span><span class="token punctuation">&gt;</span></span>
    <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>strong</span><span class="token punctuation">&gt;</span></span>Info - <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>strong</span><span class="token punctuation">&gt;</span></span> A simple info alert—check it out!
<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span><span class="token comment" spellcheck="true">&lt;!-- / alert-dismissable --&gt;</span>

<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>alert alert-warning alert-dismissible fade show<span class="token punctuation">"</span></span> <span class="token attr-name">role</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>alert<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>
    <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>button</span> <span class="token attr-name">type</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>button<span class="token punctuation">"</span></span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>btn-close<span class="token punctuation">"</span></span> <span class="token attr-name">data-bs-dismiss</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>alert<span class="token punctuation">"</span></span> <span class="token attr-name">aria-label</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>Close<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>button</span><span class="token punctuation">&gt;</span></span>
    <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>strong</span><span class="token punctuation">&gt;</span></span>Warning - <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>strong</span><span class="token punctuation">&gt;</span></span> A simple warning alert—check it out!
<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span><span class="token comment" spellcheck="true">&lt;!-- / alert-dismissable --&gt;</span>

<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>alert alert-danger alert-dismissible fade show<span class="token punctuation">"</span></span> <span class="token attr-name">role</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>alert<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>
    <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>button</span> <span class="token attr-name">type</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>button<span class="token punctuation">"</span></span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>btn-close<span class="token punctuation">"</span></span> <span class="token attr-name">data-bs-dismiss</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>alert<span class="token punctuation">"</span></span> <span class="token attr-name">aria-label</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>Close<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>button</span><span class="token punctuation">&gt;</span></span>
    <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>strong</span><span class="token punctuation">&gt;</span></span>Primary - <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>strong</span><span class="token punctuation">&gt;</span></span> A simple danger alert—check it out!
<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span><span class="token comment" spellcheck="true">&lt;!-- / alert-dismissable --&gt;</span></code></pre>
                                    <!-- / code -->
                                </div><!-- / preview-code -->
                            </div><!-- / preview code-->
                        </div>
                    </div><!-- / ui-card -->
                </div><!-- / column -->
            </div><!-- / row -->
        </div><!-- / column -->
        <div class="col-xl-3">
            <div class="on-page-sidebar">
                <div class="sticky-top">
                    <p class="on-page-title">On this page</p>
                    <div class="on-page-content">
                        <ul id="nav-scroll" class="nav flex-column comp-sidenav">
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url() ?>/docs/alerts#section-1">Dismissable
                                    Alerts</a>
                            </li><!-- / nav-item -->
                        </ul>
                    </div><!-- on-page-content -->
                </div><!-- / sticky-top -->
            </div><!-- / on-page-sidebar -->
        </div><!-- / column -->
    </div><!-- / row -->
</div>