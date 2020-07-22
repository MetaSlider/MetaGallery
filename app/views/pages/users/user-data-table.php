<?php

use KevinBatdorf\App; ?>
<div
    x-data="{
        data: null,
        getData(clearcache = false) {
            this.data = null
            window.axios.get(`<?php echo get_rest_url( null, App::$slug . '/v1/users' ); ?>?clearcache=${clearcache}`)
                .then(({data}) => {
                    this.data = data.success ? data : null
                    this.$nextTick(() => {
                        this.$refs.table.style['min-height'] = this.$refs.table.offsetHeight + 'px'
                    })
                })
        },
        start() {
            if (window.userData) {
                return this.data = userData
            }
            this.getData()
        },
        prepareData(data) {
            let possibleDate = (new Date(data))
            if (data > 10000 && possibleDate.getTime() > 0) {
                return possibleDate.toDateString()
            }
            return data
        }
    }"
    x-init="start"
    x-cloak>
    <div x-ref="table" style="margin-bottom:1rem;min-height:189px">
        <template x-if="data">
            <table style="border-collapse:collapse;width:100%">
                <caption style="text-align:left;font-weight:bold;margin-bottom:0.5rem" x-text="data.title"></caption>
                <tr>
                    <template x-for="(header, index) in data.data.headers" :key="index">
                        <th style="padding:0.25rem;text-align:left;border:1px solid" scope="col" x-text="header"></th>
                    </template>
                </tr>
                <template x-for="(row, index) in Object.values(data.data.rows)" :key="index">
                    <tr>
                        <!-- Limit this to the header length so no chance of overflow if data gets changed -->
                        <template x-for="(item, index) in Array.from({ length: data.data.headers.length })">
                            <td style="padding:0.25rem;text-align:left;border:1px solid" x-text="prepareData(Object.values(row)[index])"></td>
                        </template>
                    </tr>
                </template>
            </table>
        </template>
    </div>
    <?php if ( is_admin() ) { ?>
        <button
            @click="getData(clearcache = true)"
            x-cloak
            style="background-color:#FF982D;border-color:#FF982D;color:#fff;border:0;border-radius:3px;cursor:pointer;display:inline-block;margin:0;text-decoration:none;text-align:center;vertical-align:middle;white-space:nowrap;text-shadow:none;box-shadow:none;outline:none;font-size:13px;font-weight:600;padding:8px 12px;min-height:35px">
            <span x-show="!data"><?php _e( 'Loading...', App::$slug ); ?></span>
            <span x-show="data"><?php _e( 'Refresh Data', App::$slug ); ?></span>
        </button>
    <?php } ?>
</div>