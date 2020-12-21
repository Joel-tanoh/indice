<?php

namespace App\Utility;

class Pagination extends Utility
{
    /**
     * Barre de pagination.
     * 
     * @return string
     */
    public function paginationBar()
    {
        return <<<HTML
        <div class="pagination-bar">
            <nav>
                <ul class="pagination justify-content-center">
                    <li class="page-item"><a class="page-link active" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">Next</a></li>
                </ul>
            </nav>
        </div>
HTML;
    }
}