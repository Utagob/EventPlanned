<?php

require_once("events_model.inc.php");

function show($event){
    $calendar = '<svg width="11" height="12" viewBox="0 0 11 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5.4 6.6H8.4V9.6H5.4V6.6ZM9.6 1.2H9V0H7.8V1.2H3V0H1.8V1.2H1.2C0.54 1.2 0 1.74 0 2.4V10.8C0 11.46 0.54 12 1.2 12H9.6C10.26 12 10.8 11.46 10.8 10.8V2.4C10.8 1.74 10.26 1.2 9.6 1.2ZM9.6 2.4V3.6H1.2V2.4H9.6ZM1.2 10.8V4.8H9.6V10.8H1.2Z" fill="black"/>
                    </svg>';
    $waypoint = '<svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9.80032 6.12519C9.80032 4.77152 8.70391 3.67511 7.35024 3.67511C5.99657 3.67511 4.90016 4.77152 4.90016 6.12519C4.90016 7.47886 5.99657 8.57527 7.35024 8.57527C8.70391 8.57527 9.80032 7.47886 9.80032 6.12519ZM6.1252 6.12519C6.1252 5.45142 6.67647 4.90015 7.35024 4.90015C8.02401 4.90015 8.57528 5.45142 8.57528 6.12519C8.57528 6.79896 8.02401 7.35023 7.35024 7.35023C6.67647 7.35023 6.1252 6.79896 6.1252 6.12519Z" fill="black"/>
                    <path d="M6.99497 13.3591C7.0991 13.4326 7.22773 13.4755 7.35024 13.4755C7.47274 13.4755 7.60137 13.4387 7.7055 13.3591C7.88925 13.2243 12.2688 10.0698 12.2504 6.11909C12.2504 3.41788 10.0514 1.21893 7.35024 1.21893C4.64902 1.21893 2.45008 3.41788 2.45008 6.11909C2.4317 10.0637 6.81122 13.2243 6.99497 13.3591ZM7.35024 2.4501C9.37768 2.4501 11.0254 4.09778 11.0254 6.12522C11.0376 8.8448 8.33639 11.2888 7.35024 12.0912C6.36408 11.2888 3.66287 8.85093 3.67512 6.12522C3.67512 4.09778 5.3228 2.4501 7.35024 2.4501Z" fill="black"/>
                    </svg>';

    $isLiked = !empty($event['is_liked']);

    $emptyHeartSvg = '<svg width="18" height="18" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M10.1 16.9482L10 17.0572L9.89 16.9482C5.14 12.2507 2 9.14441 2 5.99455C2 3.81471 3.5 2.17984 5.5 2.17984C7.04 2.17984 8.54 3.26975 9.07 4.75204H10.93C11.46 3.26975 12.96 2.17984 14.5 2.17984C16.5 2.17984 18 3.81471 18 5.99455C18 9.14441 14.86 12.2507 10.1 16.9482ZM14.5 0C12.76 0 11.09 0.882834 10 2.26703C8.91 0.882834 7.24 0 5.5 0C2.42 0 0 2.6267 0 5.99455C0 10.1035 3.4 13.4714 8.55 18.5613L10 20L11.45 18.5613C16.6 13.4714 20 10.1035 20 5.99455C20 2.6267 17.58 0 14.5 0Z" fill="black"/> </svg>';
    $filledHeartSvg = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 8C12 8 12 8 12.76 7C13.64 5.84 14.94 5 16.5 5C18.99 5 21 7.01 21 9.5C21 10.43 20.72 11.29 20.24 12C19.43 13.21 12 21 12 21C12 21 4.57 13.21 3.76 12C3.28 11.29 3 10.43 3 9.5C3 7.01 5.01 5 7.5 5C9.06 5 10.37 5.84 11.24 7C12 8 12 8 12 8Z" fill="black"/><path d="M11.24 7L12 8L12.76 7C13.64 5.84 14.94 5 16.5 5C18.99 5 21 7.01 21 9.5C21 10.43 20.72 11.29 20.24 12C19.43 13.21 12 21 12 21C12 21 4.57 13.21 3.76 12C3.28 11.29 3 10.43 3 9.5C3 7.01 5.01 5 7.5 5C9.06 5 10.36 5.84 11.24 7Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>';

    $heartClass = $isLiked ? 'eventHeart a' : 'eventHeart';
    $currentHeartSvg = $isLiked ? $filledHeartSvg : $emptyHeartSvg;

    $heart = '<button class="' . $heartClass . '" data-event-id="' . htmlspecialchars((string)$event['id']) . '" onclick="event.stopPropagation();" style="width: 15px; height: 15px; display: flex; align-items: center; gap: 5px; background: transparent; border: none; cursor: pointer; color: inherit; font: inherit;">
            ' . $currentHeartSvg . '
        </button>';

    if ($event['event_time'] === '0000-00-00') {
        $displayDate = 'TBA';
    } else {
        $dateObj = new DateTime($event['event_time']);
        $displayDate = $dateObj->format('d.m.Y');
    }

    echo '<div class="event" style="--event-img: url(\'../' . htmlspecialchars($event['image']) . '\');">';

    echo '<div class="event-meta-row">';
    echo '    <p class="eventInfo">' . $calendar . $displayDate . ' | ' . $waypoint . htmlspecialchars($event['event_location']) . '</p>';
    echo '    ' . $heart;
    echo '</div>';

    echo '<div class="event-details-row">';
    echo '    <p class="eventTitle">' . htmlspecialchars($event['event_name']) . '</p>';
    echo '    <p class="price">' . htmlspecialchars($event['price']) . ' MDL</p>';
    echo '</div>';

    echo '</div>';
}

function show_events_by_label(array $events) {
    if (empty($events)) {
        echo '<p>No events found.</p>';
        return;
    }

    $groupedEvents = [];
    foreach ($events as $event) {
        $label = !empty($event['label']) ? $event['label'] : 'General';
        $groupedEvents[$label][] = $event;
    }

    foreach ($groupedEvents as $label => $eventList) {
        echo '<div class="category-section">';
        echo '    <h4 class="category-title">' . htmlspecialchars($label) . '</h4>';
        
        echo '    <div class="scroll-wrapper">';
        
        echo '        <button class="scroll-arrow left-arrow" onclick="this.nextElementSibling.scrollBy({left: -400, behavior: \'smooth\'})">&#10094;</button>';
        
        echo '        <div class="category-scroll-container">';
        foreach ($eventList as $event) {
            show($event); 
        }
        echo '        </div>';
        
        echo '        <button class="scroll-arrow right-arrow" onclick="this.previousElementSibling.scrollBy({left: 400, behavior: \'smooth\'})">&#10095;</button>';
        
        echo '    </div>';
        echo '</div>';
    }
}