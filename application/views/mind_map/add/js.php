<script type="text/javascript" src="<?= base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/fontawesome/js/all.min.js"></script>
<script src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>


<script src="<?= base_url(); ?>assets/vendor/mind-wired/dist/mind-wired.js"></script>


<script>
    let mwd;
    window.onload = () => {
        window.mindwired
            .init({
                el: "#mmap-root",
                ui: {
                    width: '100%',
                    height: 800
                },
            })
            .then((instance) => {
                mwd = instance;
                // install nodes here
                mwd.nodes({
                    model: {
                        type: "text",
                        text: "Mind-Wired",
                    },
                    view: {
                        x: 0,
                        y: 0,
                        layout: {
                            type: 'X-AXIS'
                        },
                        edge: {
                            name: 'mustache_lr',
                            color: '#9aabaf',
                            width: 1
                        }
                    },
                    subs: [{
                            model: {
                                text: "Mindmap Memo",
                                schema: 'memo'
                            },
                            view: {
                                x: 0,
                                y: -150,
                                edge: {
                                    name: 'line',
                                    color: '#9a9c12',
                                    width: 1
                                }
                            },

                        },
                        {
                            model: {
                                text: "Layout"
                            },
                            view: {
                                x: 140,
                                y: -80
                            },
                            subs: [{
                                    model: {
                                        text: "DEFAULT"
                                    },
                                    view: {
                                        x: 100,
                                        y: -40
                                    }
                                },
                                {
                                    model: {
                                        text: "X-AXIS"
                                    },
                                    view: {
                                        x: 100,
                                        y: 0
                                    }
                                },
                                {
                                    model: {
                                        text: "Y-AXIS"
                                    },
                                    view: {
                                        x: 100,
                                        y: 40
                                    }
                                },
                            ],
                        },
                    ],
                });
            });
    }


    /* START: out of box code */
    const el = document.querySelector('.ctrl');
    el.addEventListener('click', (e) => {
        const {
            cmd
        } = e.target.dataset
        if (cmd === 'export') {
            mwd.export().then(json => {
                const dimmer = document.querySelector('.dimmer');
                dimmer.style.display = ''
                dimmer.querySelector('textarea').value = json;
            })
        }
    })
    const btnClose = document.querySelector('[data-cmd="close"]');
    btnClose.addEventListener('click', () => {
        document.querySelector('.dimmer').style.display = 'none'
    });


    $('#btnSave').click(function() {
        mwd.export("json").then((json) => {
            console.log(JSON.parse(json));
            // saved on localStorage or sent to backend-server
        });
    });

    // btnSave.addEventListener('click', () => {
    //     // 2. export as json

    // }, false)
    /* END: out of box code */
</script>