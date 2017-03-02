<?php

foreach ($tags as $tags) {
	printf('<button class="btn btn-primary tag">%s</button>', h($tags->title));
}
