<div class="container-fluid mb-4">
    <div class="row align-items-center page-title">
        <div class="col-12 col-md mb-2 mb-sm-0">
            <h5 class="mb-0">Accordions</h5>
        </div>
    </div>
    <div class="row">
        <nav aria-label="breadcrumb" class="breadcrumb-theme">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Components</li>
                <li class="breadcrumb-item active" aria-current="page">Accordion</li>
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
                            <h4 class="alert-heading">Default Accordion!</h4>
                            <p> You can use a link with the href attribute, or a button with the data-target attribute.
                                In both cases, the <code>data-bs-toggle="collapse"</code> is required.</p>
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
                            <div class="tab-pane show active" id="tab1-preview">
                                <div class="accordion" id="accordionExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingOne">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapseOne" aria-expanded="true"
                                                aria-controls="collapseOne">Panel One <i
                                                    class="fas fa-chevron-down"></i></button>
                                        </h2><!-- / accordion-header -->
                                        <div id="collapseOne" class="accordion-collapse collapse show"
                                            aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                Vivamus ut vestibulum quam. Duis at urna convallis, porta odio ac,
                                                varius ex. Cras ultrices quam eros, vitae auctor enim luctus at. Sed
                                                facilisis, ante eu malesuada consectetur, nunc dolor bibendum eros, eu
                                                suscipit nisl elit in arcu vulputate.
                                            </div><!-- / accordion-body -->
                                        </div><!-- / collapse -->
                                    </div><!-- / accordion-item -->

                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingTwo">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                                                aria-expanded="false" aria-controls="collapseTwo">Panel Two <i
                                                    class="fas fa-chevron-down"></i></button>
                                        </h2><!-- / accordion-header -->
                                        <div id="collapseTwo" class="accordion-collapse collapse"
                                            aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                Vivamus ut vestibulum quam. Duis at urna convallis, porta odio ac,
                                                varius ex. Cras ultrices quam eros, vitae auctor enim luctus at. Sed
                                                facilisis, ante eu malesuada consectetur, nunc dolor bibendum eros, eu
                                                suscipit nisl elit in arcu vulputate.
                                            </div><!-- / accordion-body -->
                                        </div><!-- / collapse -->
                                    </div><!-- / accordion-item -->

                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingThree">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapseThree"
                                                aria-expanded="false" aria-controls="collapseThree">Panel Three <i
                                                    class="fas fa-chevron-down"></i></button>
                                        </h2><!-- / accordion-header -->
                                        <div id="collapseThree" class="accordion-collapse collapse"
                                            aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                Vivamus ut vestibulum quam. Duis at urna convallis, porta odio ac,
                                                varius ex. Cras ultrices quam eros, vitae auctor enim luctus at. Sed
                                                facilisis, ante eu malesuada consectetur, nunc dolor bibendum eros, eu
                                                suscipit nisl elit in arcu vulputate.
                                            </div><!-- / accordion-body -->
                                        </div><!-- / collapse -->
                                    </div><!-- / accordion-item -->
                                </div><!-- / accordion -->
                            </div><!-- / preview-->

                            <div class="tab-pane" id="tab1-code">
                                <div class="preview-code">
                                    <div
                                        class="d-flex align-items-center highlight-toolbar ps-3 pe-2 py-1 border-0 border-top border-bottom">
                                        <small class="font-monospace text-body-secondary text-uppercase">html</small>
                                        <div class="d-flex ms-auto">
                                            <button type="button" class="btn btn-icon btn-sm btn-outline mt-0 me-0"
                                                aria-label="Copy to clipboard"
                                                data-bs-original-title="Copy to clipboard">
                                                <i class="bi bi-clipboard"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <pre class="language-markup">
                                        <code id="code-1" class="language-html rounded hljs language-xml" style="">
&lt;div class="accordion" id="accordionExample">
    &lt;div class="accordion-item">
        &lt;h2 class="accordion-header" id="headingOne">
            &lt;button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Panel One &lt;i class="fas fa-chevron-down">&lt;/i>&lt;/button>
        &lt;/h2>&lt;!-- / accordion-header -->
        &lt;div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
            &lt;div class="accordion-body">
                ...
            &lt;/div>&lt;!-- / accordion-body -->
        &lt;/div>&lt;!-- / collapse -->
    &lt;/div>&lt;!-- / accordion-item -->

    &lt;div class="accordion-item">
        &lt;h2 class="accordion-header" id="headingTwo">
            &lt;button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">Panel Two &lt;i class="fas fa-chevron-down">&lt;/i>&lt;/button>
        &lt;/h2>&lt;!-- / accordion-header -->
        &lt;div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
            &lt;div class="accordion-body">
                ...
            &lt;/div>&lt;!-- / accordion-body -->
        &lt;/div>&lt;!-- / collapse -->
    &lt;/div>&lt;!-- / accordion-item -->

    &lt;div class="accordion-item">
        &lt;h2 class="accordion-header" id="headingThree">
            &lt;button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">Panel Three &lt;i class="fas fa-chevron-down">&lt;/i>&lt;/button>
        &lt;/h2>&lt;!-- / accordion-header -->
        &lt;div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
            &lt;div class="accordion-body">
                ...
            &lt;/div>&lt;!-- / accordion-body -->
        &lt;/div>&lt;!-- / collapse -->
    &lt;/div>&lt;!-- / accordion-item -->
&lt;/div>&lt;!-- / accordion -->
                                        </code>
                                    </pre><!-- / code -->
                                </div><!-- / preview-code -->
                            </div><!-- / preview code-->
                        </div><!-- / tab-content-->
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
                                <a class="nav-link" href="<?= base_url() ?>/docs/accordions#section-1">Default
                                    Accordion</a>
                            </li><!-- / nav-item -->
                        </ul>
                    </div><!-- on-page-content -->
                </div><!-- / sticky-top -->
            </div><!-- / on-page-sidebar -->
        </div><!-- / column -->
    </div><!-- / row -->
</div>