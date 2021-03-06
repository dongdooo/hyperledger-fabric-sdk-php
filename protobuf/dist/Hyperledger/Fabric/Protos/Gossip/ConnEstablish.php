<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: gossip/message.proto

namespace Hyperledger\Fabric\Protos\Gossip;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * ConnEstablish is the message used for the gossip handshake
 * Whenever a peer connects to another peer, it handshakes
 * with it by sending this message that proves its identity
 *
 * Generated from protobuf message <code>gossip.ConnEstablish</code>
 */
class ConnEstablish extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>bytes pki_id = 1;</code>
     */
    private $pki_id = '';
    /**
     * Generated from protobuf field <code>bytes identity = 2;</code>
     */
    private $identity = '';
    /**
     * Generated from protobuf field <code>bytes tls_cert_hash = 3;</code>
     */
    private $tls_cert_hash = '';

    public function __construct() {
        \GPBMetadata\Gossip\Message::initOnce();
        parent::__construct();
    }

    /**
     * Generated from protobuf field <code>bytes pki_id = 1;</code>
     * @return string
     */
    public function getPkiId()
    {
        return $this->pki_id;
    }

    /**
     * Generated from protobuf field <code>bytes pki_id = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setPkiId($var)
    {
        GPBUtil::checkString($var, False);
        $this->pki_id = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>bytes identity = 2;</code>
     * @return string
     */
    public function getIdentity()
    {
        return $this->identity;
    }

    /**
     * Generated from protobuf field <code>bytes identity = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setIdentity($var)
    {
        GPBUtil::checkString($var, False);
        $this->identity = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>bytes tls_cert_hash = 3;</code>
     * @return string
     */
    public function getTlsCertHash()
    {
        return $this->tls_cert_hash;
    }

    /**
     * Generated from protobuf field <code>bytes tls_cert_hash = 3;</code>
     * @param string $var
     * @return $this
     */
    public function setTlsCertHash($var)
    {
        GPBUtil::checkString($var, False);
        $this->tls_cert_hash = $var;

        return $this;
    }

}

