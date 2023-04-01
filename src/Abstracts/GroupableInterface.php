<?php

namespace App\Abstracts;

use App\Entity\Groupe;

interface GroupableInterface
{
    /**
     * Gets the groups granted to the user.
     *
     * @return \Traversable
     */
    public function getGroups();

    /**
     * Gets the name of the groups which includes the user.
     *
     * @return array
     */
    public function getGroupNames();

    /**
     * Indicates whether the user belongs to the specified group or not.
     *
     * @param string $name Name of the group
     *
     * @return bool
     */
    public function hasGroup($name);

    /**
     * Add a group to the user groups.
     *
     * @param Groupe $group
     *
     * @return static
     */
    public function addGroup(Groupe $group);

    /**
     * Remove a group from the user groups.
     *
     * @param Groupe $group
     *
     * @return static
     */
    public function removeGroup(Groupe $group);
}
