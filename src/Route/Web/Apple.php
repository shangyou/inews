<?php

namespace Route\Web;

use Model\Event;
use Model\Model;
use Pagon\View;
use Route\Web;

class Apple extends Web
{
    protected $tpl = 'apple.php';
    protected $title = 'Apple\'s Timeline';

    public function get()
    {
        $tag = $this->input->query('type');
        $this->data['tags'] = Event::findAllTags();

        $dates = array();
        $EVENT = Event::dispense();

        if ($tag) {
            $EVENT->where('tag', $tag);
        }

        $length = array();
        $current = array();
        $infos = array();

        foreach ($EVENT->order_by_desc('start_at')->find_many() as $item) {
            $d = array(
                'startDate' => date('Y,n,d', strtotime($item->start_at)),
                'endDate'   => date('Y,n,d', strtotime($item->end_at)),
                'headline'  => $item->title,
                'text'      => $item->body . ($item->link ? ' <a href="' . $item->link . '" target=_blank>More...</a>' : ''),
                'asset'     => array(
                    'media'     => $item->media,
                    'thumbnail' => $item->thumb ? $item->thumb : '/static/apple/' . str_replace(' ', '', strtolower($item->tag)) . '.jpg',
                    'caption'   => $item->caption
                ),
            );

            $dates[] = $d;

            if (!isset($current[$item->tag])) {
                $current[$item->tag] = $item->start_at;
                $infos[$item->tag]['latest'] = ceil((time() - strtotime($item->start_at)) / 86400);
                $infos[$item->tag]['date'] = substr($item->start_at, 0, 10);
                $infos[$item->tag]['avg'] = null;
            } else {
                $length[$item->tag][] = (strtotime($current[$item->tag]) - strtotime($item->start_at)) / 86400;
                $current[$item->tag] = $item->start_at;
            }
        }

        foreach ($length as $tag => $lens) {
            $infos[$tag]['avg'] = ceil(array_sum($lens) / count($lens));
        }

        if (false) {
            array_unshift($dates, array(
                'startDate' => date('Y,n,d'),
                'endDate'   => date('Y,n,d'),
                'headline'  => 'Apple Timeline',
                'text'      => (string)$this->compile('apple_top.php', array('infos' => $infos))
            ));
        }

        $this->data['timeline'] = array(
            'timeline' => array(
                'headline' => 'Apple big events',
                'type'     => 'default',
                'text'     => '',
                'date'     => $dates
            )
        );
    }
}